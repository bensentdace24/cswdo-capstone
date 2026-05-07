import pandas as pd
import mysql.connector
import json
import os

# ======================================
# CONFIG
# ======================================
BASE_DIR = os.path.dirname(__file__)
SUMMARY_OUTPUT = os.path.join(BASE_DIR, "cluster_results.json")

# ======================================
# DATABASE CONNECTION
# ======================================
try:
    db = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="cswdo_1"
    )
except mysql.connector.Error as err:
    print(f"[ERROR] Database connection failed: {err}")
    exit()

print("[INFO] Connected to database")

# ======================================
# CLEANING FUNCTION
# ======================================
def clean_barangay(b):
    if not isinstance(b, str):
        return None

    b = b.replace("\n", " ").replace("\r", " ").strip().upper()
    b = b.replace(".", "").replace("Ñ", "N")
    
    if b.startswith("STO "):
        b = "SANTO " + b[4:]
    elif b == "STO":
        b = "SANTO"

    replacements = {
        "BARANGAY": "A.O. FLOIRENDO",
        "BALIK-PROBINSYA": "A.O. FLOIRENDO",
        "CLIENT": "A.O. FLOIRENDO",
        "TRANSIENT CLIENT": "UPPER LICANAN",
        "JP LAUREL": "J.P. LAUREL",
        "JP": "J.P. LAUREL",
        "CAGGANGOHAN": "CAGANGOHAN",
        "CGANGOHAN": "CAGANGOHAN",
        "SO DAVAO": "SOUTHERN DAVAO",
        "S O DAVAO": "SOUTHERN DAVAO",
        "SOUTHER DAVAO": "SOUTHERN DAVAO",
        "SANTO NINO": "SANTO NIÑO",
        "STA CRUZ": "SANTA CRUZ",
        "NEW VISYAS": "NEW VISAYAS",
        "NEW MALAGA": "NEW MALITBOG",
        "SAVACION": "SALVACION",
        "SENORITA": "SALVACION",
        "LEMONSITO": "KIOTOY",
        "LEMON SITO": "KIOTOY",
    }
    return replacements.get(b, b)

# ======================================
# STEP 1: GET ALL TRANSACTIONS
# ======================================
print("\n[INFO] Fetching ALL transactions...")

transaction_query = """
SELECT
    ar.id AS transaction_id,
    ar.barangay,
    ar.amount,
    DATE_FORMAT(ar.created_at, '%Y-%m-%d') as date,
    c.full_name AS client_name
FROM acknowledgement_receipts ar
LEFT JOIN clients c ON ar.client_id = c.id
WHERE ar.barangay IS NOT NULL
  AND ar.barangay != ''
  AND ar.amount > 0
ORDER BY ar.barangay, ar.created_at
"""

df_transactions = pd.read_sql(transaction_query, db)

# Clean barangay names
df_transactions["barangay"] = df_transactions["barangay"].apply(clean_barangay)
df_transactions = df_transactions.dropna(subset=["barangay"])

print(f"[INFO] Found {len(df_transactions)} total transactions")

if df_transactions.empty:
    print("[ERROR] No transactions found!")
    exit()

# ======================================
# STEP 2: ASSIGN TRANSACTION COLORS (PER TRANSACTION)
# ======================================
print("\n[INFO] Assigning transaction colors based on amount:")
print("   - Low Need (Green): 500 - 799")
print("   - Medium Need (Yellow): 800 - 999")
print("   - High Need (Red): 1000 - 1200")

def get_transaction_color(amount):
    """Color for individual transactions"""
    if amount >= 1000:
        return "High Need"
    elif amount >= 800:
        return "Medium Need"
    else:
        return "Low Need"

df_transactions['transaction_color'] = df_transactions['amount'].apply(get_transaction_color)
df_transactions['cluster_label'] = df_transactions['transaction_color']

# ======================================
# STEP 3: CREATE SUMMARY DATA FOR FULL DISTRIBUTION
# ======================================
print("\n[INFO] Creating FULL DISTRIBUTION summary (1 dot per barangay)...")

# 1. Calculate Need Index per barangay: Total Amount + (Count * 500)
brgy_summary = df_transactions.groupby('barangay').agg(
    total_amount=('amount', 'sum'),
    total_assistances=('amount', 'count')
)
brgy_summary['need_index'] = brgy_summary['total_amount'] + (brgy_summary['total_assistances'] * 500)

# 2. Calculate dynamic thresholds based on Need Index
high_threshold = brgy_summary['need_index'].quantile(0.70)
low_threshold = brgy_summary['need_index'].quantile(0.30)

# Fallback for small or uniform datasets
if high_threshold == low_threshold:
    high_threshold = brgy_summary['need_index'].mean() + 1
    low_threshold = brgy_summary['need_index'].mean()

print(f"[INFO] Dynamic Thresholds (Index): High >= {high_threshold:.1f}, Low < {low_threshold:.1f}")

summary_data = []
for barangay, row in brgy_summary.iterrows():
    total_amount = float(row['total_amount'])
    total_assistances = int(row['total_assistances'])
    score = float(row['need_index'])

    # Use dynamic thresholds on the Need Index
    if score >= high_threshold:
        cluster_label = "High Need"
    elif score >= low_threshold:
        cluster_label = "Medium Need"
    else:
        cluster_label = "Low Need"

    # Get the raw group for breakdown
    group = df_transactions[df_transactions['barangay'] == barangay]

    summary_data.append({
        'barangay': barangay,
        'total_assistances': total_assistances,
        'total_amount': total_amount,
        'cluster_label': cluster_label,
        'breakdown': {
            'high': int((group['transaction_color'] == 'High Need').sum()),
            'medium': int((group['transaction_color'] == 'Medium Need').sum()),
            'low': int((group['transaction_color'] == 'Low Need').sum())
        }
    })
        'barangay': barangay,
        'total_assistances': total_assistances,
        'total_amount': total_amount,
        'cluster_label': cluster_label,
        'breakdown': {
            'high': int((group['transaction_color'] == 'High Need').sum()),
            'medium': int((group['transaction_color'] == 'Medium Need').sum()),
            'low': int((group['transaction_color'] == 'Low Need').sum())
        }
    })

df_summary = pd.DataFrame(summary_data)
print(f"[INFO] Found {len(df_summary)} barangays")

# ======================================
# STEP 4: SAVE FULL DISTRIBUTION JSON
# ======================================
result_summary = df_summary[['barangay', 'total_assistances', 'total_amount', 'cluster_label']]

with open(SUMMARY_OUTPUT, "w", encoding="utf-8") as f:
    json.dump(result_summary.to_dict(orient="records"), f, indent=4)

print(f"[INFO] Saved FULL DISTRIBUTION to: {SUMMARY_OUTPUT}")

# ======================================
# STEP 5: SAVE PER-BARANGAY TRANSACTION FILES
# ======================================
print("\n[INFO] Saving PER-BARANGAY transaction files...")

def normalize_filename(barangay):
    """Match barangay names exactly as they appear in files"""
    if not barangay:
        return ''

    clean_name = str(barangay).strip().upper()

    mapping = {
        'A O FLORIENDO': 'A._O._FLOIRENDO',
        'A.O. FLORIENDO': 'A._O._FLOIRENDO',
        'A. O. FLORIENDO': 'A._O._FLOIRENDO',
        'A O FLOIRENDO': 'A._O._FLOIRENDO',
        'A.O. FLOIRENDO': 'A._O._FLOIRENDO',
        'JP LAUREL': 'J.P._LAUREL',
        'J.P. LAUREL': 'J.P._LAUREL',
        'J. P. LAUREL': 'J.P._LAUREL',
        'BUENAVISTA': 'BUENAVISTA',
        'CACAO': 'CACAO',
        'CAGANGOHAN': 'CAGANGOHAN',
        'CONSOLACION': 'CONSOLACION',
        'DAPCO': 'DAPCO',
        'DATU ABDUL DADIA': 'DATU_ABDUL_DADIA',
        'GREDU': 'GREDU',
        'KASILAK': 'KASILAK',
        'KATIPUNAN': 'KATIPUNAN',
        'KATUALAN': 'KATUALAN',
        'KAUSWAGAN': 'KAUSWAGAN',
        'KIOTOY': 'KIOTOY',
        'LITTLE PANAY': 'LITTLE_PANAY',
        'LOWER PANAGA': 'LOWER_PANAGA',
        'MABUNAO': 'MABUNAO',
        'MADUAO': 'MADUAO',
        'MALATIVAS': 'MALATIVAS',
        'MANAY': 'MANAY',
        'NANYO': 'NANYO',
        'NEW MALAGA': 'NEW_MALAGA',
        'NEW MALITBOG': 'NEW_MALITBOG',
        'NEW PANDAN': 'NEW_PANDAN',
        'NEW VISAYAS': 'NEW_VISAYAS',
        'QUEZON': 'QUEZON',
        'SALVACION': 'SALVACION',
        'SAN FRANCISCO': 'SAN_FRANCISCO',
        'SAN NICOLAS': 'SAN_NICOLAS',
        'SAN PEDRO': 'SAN_PEDRO',
        'SAN ROQUE': 'SAN_ROQUE',
        'SAN VICENTE': 'SAN_VICENTE',
        'SANTA CRUZ': 'SANTA_CRUZ',
        'SANTO NIÑO': 'SANTO_NIÑO',
        'SANTO NINO': 'SANTO_NIÑO',
        'STO. NIÑO': 'SANTO_NIÑO',
        'STO NIÑO': 'SANTO_NIÑO',
        'STO. NINO': 'SANTO_NIÑO',
        'STO NINO': 'SANTO_NIÑO',
        'SINDATON': 'SINDATON',
        'SOUTHERN DAVAO': 'SOUTHERN_DAVAO',
        'TAGPORE': 'TAGPORE',
        'TIBUNGOL': 'TIBUNGOL',
        'UPPER LICANAN': 'UPPER_LICANAN',
        'WATERFALL': 'WATERFALL',
    }

    if clean_name in mapping:
        return mapping[clean_name]

    no_spaces = clean_name.replace(' ', '_')
    if no_spaces in mapping:
        return mapping[no_spaces]

    return no_spaces

# Save per-barangay transaction files
for barangay, group in df_transactions.groupby('barangay'):
    transaction_data = []

    for _, row in group.iterrows():
        client_name = str(row['client_name']) if pd.notna(row['client_name']) else f"Client {row['transaction_id']}"
        if len(client_name) > 25:
            client_name = client_name[:22] + "..."

        transaction_data.append({
            'transaction_id': int(row['transaction_id']),
            'amount': float(row['amount']),
            'cluster_label': row['transaction_color'],
            'cluster': row['transaction_color'],
            'date': str(row['date']) if pd.notna(row['date']) else None,
            'client': client_name
        })

    safe_name = normalize_filename(barangay)
    file_path = os.path.join(BASE_DIR, f"cluster_results_{safe_name}.json")

    with open(file_path, "w", encoding="utf-8") as f:
        json.dump(transaction_data, f, indent=4)

    print(f"[INFO] Saved {len(transaction_data)} transactions to: cluster_results_{safe_name}.json")

print("\n--- DONE ---")
print("   - FULL DISTRIBUTION: 1 dot per barangay, colored by TOTAL amount")
print("   - PER BARANGAY: Multiple dots per transaction, colored by individual amount")
