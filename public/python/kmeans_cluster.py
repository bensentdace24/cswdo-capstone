import pandas as pd
import mysql.connector
from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler
import numpy as np
import json
import os

# ======================================
# Ensure output folder exists
# ======================================
os.makedirs("public/python", exist_ok=True)

# ======================================
# Database connection
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

# ======================================
# FINAL CLEANING FUNCTION (YOUR ORIGINAL)
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

        # J.P. Laurel variants
        "JP LAUREL": "J.P. LAUREL",
        "JP": "J.P. LAUREL",

        # Cagangohan
        "CAGGANGOHAN": "CAGANGOHAN",
        "CGANGOHAN": "CAGANGOHAN",

        # Southern Davao
        "SO DAVAO": "SOUTHERN DAVAO",
        "S O DAVAO": "SOUTHERN DAVAO",
        "SOUTHER DAVAO": "SOUTHERN DAVAO",

        # Sto Niño variants (now handled by STO->SANTO and dot removal)
        "SANTO NINO": "SANTO NIÑO",

        # Sta Cruz
        "STA CRUZ": "SANTA CRUZ",

        # New Visayas
        "NEW VISYAS": "NEW VISAYAS",
        "NEW MALAGA": "NEW MALITBOG",

        # Salvacion
        "SAVACION": "SALVACION",
        "SENORITA": "SALVACION",

        # Lemonsito → Kiotoy
        "LEMONSITO": "KIOTOY",
        "LEMON SITO": "KIOTOY",
    }

    return replacements.get(b, b)

# ======================================
# 3. LOAD RAW RECEIPT DATA (NO JOIN!)
# ======================================
query = """
SELECT
    barangay,
    amount
FROM acknowledgement_receipts
WHERE barangay IS NOT NULL AND barangay != ''
"""

raw = pd.read_sql(query, db)

# ======================================
# CLEAN BARANGAY NAMES BEFORE GROUPING
# ======================================
raw["barangay"] = raw["barangay"].apply(clean_barangay)
raw = raw.dropna(subset=["barangay"])

# Fix spelling to A.O. FLOIRENDO
raw["barangay"] = raw["barangay"].replace({
    "A.O FLORIENDO": "A.O. FLOIRENDO",
    "A O FLORIENDO": "A.O. FLOIRENDO",
    "A.O. FLORIENDO": "A.O. FLOIRENDO",
    "A O FLOIRENDO": "A.O. FLOIRENDO"
})

# ======================================
# 4. GROUP PROPERLY (NO DUPLICATES)
# ======================================
barangay_data = raw.groupby("barangay").agg(
    total_assistances=("amount", "count"),
    total_amount=("amount", "sum")
).reset_index()

print("Barangays detected:", barangay_data.shape[0])

# ======================================
# Weighted Need Index Calculation
# ======================================
# We combine Frequency (Count) and Intensity (Amount)
# Index = Total Amount + (Count * 500)
# This ensures a barangay with few but expensive transactions is still flagged.
barangay_data["need_index"] = barangay_data["total_amount"] + (barangay_data["total_assistances"] * 500)

# ======================================
# Dynamic Threshold Calculation (Quantiles)
# ======================================
high_threshold = barangay_data['need_index'].quantile(0.70) # Top 30%
low_threshold = barangay_data['need_index'].quantile(0.30)  # Bottom 30%

# Handle edge case where all data is the same
if high_threshold == low_threshold:
    high_threshold = barangay_data['need_index'].mean() + 1
    low_threshold = barangay_data['need_index'].mean()

def assign_label(row):
    score = row['need_index']
    if score >= high_threshold:
        return "High Need"
    elif score >= low_threshold:
        return "Medium Need"
    else:
        return "Low Need"

print(f"Dynamic Thresholds (Index): Low < {low_threshold:.1f}, High >= {high_threshold:.1f}")

barangay_data["cluster_label"] = barangay_data.apply(assign_label, axis=1)
# Keep cluster_idx for compatibility
label_to_idx = {"High Need": 0, "Medium Need": 1, "Low Need": 2}
barangay_data["cluster_idx"] = barangay_data["cluster_label"].map(label_to_idx)

# ======================================
# SAVE JSON
# ======================================
output_path = os.path.join(os.path.dirname(__file__), 'cluster_results.json')

with open(output_path, "w") as f:
    json.dump(barangay_data.to_dict(orient='records'), f, indent=4)

print("\n--- FINAL CLEAN K-MEANS COMPLETE ---")
print("Saved to:", output_path)
