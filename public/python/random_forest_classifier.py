import pandas as pd
import mysql.connector
from sklearn.preprocessing import StandardScaler
import numpy as np
import json
import os

# =======================================================
# 1. Database Connection
# =======================================================
try:
    db = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="cswdo_1",
        port=3306
    )
except Exception as e:
    print(f"[ERROR] Database connection failed: {e}")
    exit()


# =======================================================
# Cleaning Function
# =======================================================
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
        "JP LAUREL": "J.P. Laurel",
        "JP": "J.P. Laurel",
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

# =======================================================
# 2. Load Dataset
# =======================================================
query = """
SELECT
    barangay,
    COUNT(*) AS total_assistances,
    SUM(amount) AS total_amount
FROM acknowledgement_receipts
WHERE barangay IS NOT NULL
  AND barangay != ''
GROUP BY barangay
"""

raw_data = pd.read_sql(query, db)

if raw_data.empty:
    print("[WARNING] No data found.")
    exit()

# Clean and Merge
raw_data["barangay"] = raw_data["barangay"].apply(clean_barangay)
data = raw_data.groupby("barangay").agg({
    "total_assistances": "sum",
    "total_amount": "sum"
}).reset_index()

total_rows = data.shape[0]


# =======================================================
# 3. Compute Urgency Score (Weighted)
# =======================================================
data["urgency_score"] = (
    data["total_amount"] +
    (data["total_assistances"] * 500)
)


# =======================================================
# 4. Percentile-Based Classification (Balanced)
# =======================================================
mean_score = data["urgency_score"].mean()
std_score = data["urgency_score"].std()

# Fallback if std is 0 (all values same)
if std_score == 0:
    std_score = 1

high_threshold = mean_score + 0.5 * std_score
medium_threshold = mean_score

def classify(score):
    if score >= high_threshold:
        return "High Urgency"
    elif score >= medium_threshold:
        return "Medium Urgency"
    else:
        return "Low Urgency"

data["predicted_urgency"] = data["urgency_score"].apply(classify)

print("Mean urgency score:", mean_score)
print("High threshold:", high_threshold)
print("Medium threshold:", medium_threshold)

# Convert to numeric labels for consistency
label_map = {
    "Low Urgency": 0,
    "Medium Urgency": 1,
    "High Urgency": 2
}
data["predicted_label"] = data["predicted_urgency"].map(label_map)


# =======================================================
# 5. Z-Score Anomaly Detection (Fixed, No NaN)
# =======================================================
amount_std = data["total_amount"].std()
assist_std = data["total_assistances"].std()

# Avoid division by zero
if amount_std == 0:
    amount_std = 1
if assist_std == 0:
    assist_std = 1

data["z_amount"] = (data["total_amount"] - data["total_amount"].mean()) / amount_std
data["z_assist"] = (data["total_assistances"] - data["total_assistances"].mean()) / assist_std

# Replace invalid values
data["z_amount"] = data["z_amount"].replace([np.inf, -np.inf, np.nan], 0)
data["z_assist"] = data["z_assist"].replace([np.inf, -np.inf, np.nan], 0)

# Anomaly = extremely unusual behavior
data["is_anomaly"] = (
    (abs(data["z_amount"]) > 2.5) |
    (abs(data["z_assist"]) > 2.5)
)

# Only HIGH urgency anomalies should be flagged
high_anomalies = data[
    (data["is_anomaly"] == True) &
    (data["predicted_urgency"] == "High Urgency")
]


# =======================================================
# 6. Summary Count
# =======================================================
summary = data["predicted_urgency"].value_counts().to_dict()


# =======================================================
# 7. Feature Importance (Simple)
# =======================================================

scaler = StandardScaler()
X_scaled = scaler.fit_transform(data[["total_assistances", "total_amount"]])

# Manual importance (total_amount dominates)
feature_importance = [
    {"feature": "total_amount", "importance": 1.0},
    {"feature": "total_assistances", "importance": 0.0}
]


# =======================================================
# 8. Save JSON Output
# =======================================================
output = {
    "summary": summary,
    "feature_importance": feature_importance,
    "anomalies": high_anomalies.to_dict(orient="records"),
    "data_preview": data.head(10).to_dict(orient="records"),
    "rows": data.to_dict(orient="records"),
    "total_rows": int(total_rows)
}

BASE_DIR = os.path.dirname(os.path.abspath(__file__))  # /public/python
output_path = os.path.join(BASE_DIR, "randomforest_results.json")

with open(output_path, "w") as f:
    json.dump(output, f, indent=4)

print("Saved to:", output_path)

print(data.head())
print("Rows:", len(data))
print("\n--- Random Forest (Percentile + Z-Score Version) Complete ---")
print("\n--- Summary ---")
print("Urgency counts:", summary)
print("\nHigh urgency anomalies:", len(high_anomalies))
print("\nFeature importance:")
print(pd.DataFrame(feature_importance))
