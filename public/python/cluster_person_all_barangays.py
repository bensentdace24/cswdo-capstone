import pandas as pd
import mysql.connector
from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler
import numpy as np
import json
import os

# ======================================
# CONFIG
# ======================================
BASE_DIR = os.path.dirname(__file__)
OUTPUT_DIR = BASE_DIR
os.makedirs(OUTPUT_DIR, exist_ok=True)

# ======================================
# DATABASE CONNECTION
# ======================================
db = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",          # <-- change if you have password
    database="cswdo_1"
)

# ======================================
# BARANGAY CLEANER (SAME IDEA AS YOUR MAIN)
# ======================================
def clean_barangay(b):
    if not isinstance(b, str):
        return None

    b = b.replace("\n", " ").replace("\r", " ").strip().upper()

    replacements = {
        "J.P LAUREL": "J.P. LAUREL",
        "JP LAUREL": "J.P. LAUREL",
        "J.P.": "J.P. LAUREL",
        "JP": "J.P. LAUREL",

        "STO. NIÑO": "SANTO NIÑO",
        "STO NIÑO": "SANTO NIÑO",

        "STA. CRUZ": "SANTA CRUZ",

        "SO. DAVAO": "SOUTHERN DAVAO",
        "S.O. DAVAO": "SOUTHERN DAVAO",
        "SOUTHER DAVAO": "SOUTHERN DAVAO",

        "LEMONSITO": "KIOTOY",
        "LEMON SITO": "KIOTOY",
    }

    return replacements.get(b, b)

# ======================================
# LOAD RAW DATA (PER PERSON PER BARANGAY)
# ======================================
query = """

SELECT DISTINCT UPPER(TRIM(barangay)) AS barangay
FROM acknowledgement_receipts
WHERE barangay IS NOT NULL
  AND barangay != ''
"""



# Clean barangay names
raw = pd.read_sql(query, db)

# Optional extra cleaning (if you have clean_barangay function)
raw["barangay"] = raw["barangay"].apply(clean_barangay)
raw = raw.dropna(subset=["barangay"])

barangays = sorted(raw["barangay"].unique())
print("Found barangays:", barangays)

# ======================================
# PROCESS EACH BARANGAY
# ======================================
for brgy in barangays:
    print(f"\nProcessing barangay: {brgy}")

    df = raw[raw["barangay"] == brgy]

    # Group per person inside this barangay
    person_data = df.groupby("client_id").agg(
        total_assistances=("amount", "count"),
        total_amount=("amount", "sum")
    ).reset_index()

    # Need at least 3 persons for KMeans(3)
    if person_data.shape[0] < 3:
        print(f"⚠️ Skipped {brgy}: not enough data.")
        continue

    # ======================================
    # PREPARE FEATURES
    # ======================================
    X = person_data[['total_assistances', 'total_amount']]
    scaler = StandardScaler()
    X_scaled = scaler.fit_transform(X)

    # ======================================
    # K-MEANS
    # ======================================
    kmeans = KMeans(n_clusters=3, random_state=42, n_init=10)
    person_data["cluster_idx"] = kmeans.fit_predict(X_scaled)

    centroids = kmeans.cluster_centers_
    scores = (centroids[:, 0] * 0.5) + (centroids[:, 1] * 0.5)
    order = np.argsort(scores)[::-1]

    labels = ["High Need", "Medium Need", "Low Need"]
    label_map = {order[i]: labels[i] for i in range(3)}
    person_data["cluster_label"] = person_data["cluster_idx"].map(label_map)

    # ======================================
    # SAVE JSON PER BARANGAY
    # ======================================
    safe_name = brgy.replace(" ", "_").replace(".", "")
    output_path = os.path.join(OUTPUT_DIR, f"cluster_results_person_{safe_name}.json")

    with open(output_path, "w", encoding="utf-8") as f:
        json.dump(person_data.to_dict(orient='records'), f, indent=4)

    print(f"✅ Saved: {output_path}")

print("\n🎉 DONE! All barangays processed.")
