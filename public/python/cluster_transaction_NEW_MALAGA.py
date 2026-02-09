import pandas as pd
import json
import os
import mysql.connector
from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler


def make_safe(name: str):
    name = name.upper().strip()
    name = name.replace(".", "")
    name = name.replace("(", "").replace(")", "")
    name = " ".join(name.split())   # remove double spaces
    name = name.replace(" ", "_")
    return name

# ============ CONFIG ============
DB_CONFIG = {
    "host": "127.0.0.1",
    "user": "root",
    "password": "",
    "database": "cswdo_1"   # <-- your DB name
}

OUTPUT_DIR = os.path.dirname(os.path.abspath(__file__))

# ============ CONNECT DB ============
db = mysql.connector.connect(**DB_CONFIG)

# We normalize barangay names: remove dots, trim spaces, uppercase
TARGET_BARANGAY = "NEW MALAGA"

query = """
SELECT id as transaction_id, amount
FROM acknowledgement_receipts
WHERE
    UPPER(
        REPLACE(
            REPLACE(TRIM(barangay), '.', ''), '  ', ' '
        )
    ) = %s
"""


df = pd.read_sql(query, db, params=(TARGET_BARANGAY,))


print("Transactions found:", len(df))
print(df.head())

if len(df) < 3:
    print("⚠️ Not enough data for clustering.")
    exit()

# Features: each transaction is 1 point
df["total_assistances"] = 1
df["total_amount"] = df["amount"]

X = df[["total_assistances", "total_amount"]].values

# Scale
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# KMeans (3 clusters)
kmeans = KMeans(n_clusters=3, random_state=42, n_init=10)
clusters = kmeans.fit_predict(X_scaled)

df["cluster_idx"] = clusters

# Label clusters by average amount
cluster_means = df.groupby("cluster_idx")["total_amount"].mean().sort_values()

labels = ["Low Need", "Medium Need", "High Need"]
labels_map = {}

for i, (cluster_idx, _) in enumerate(cluster_means.items()):
    labels_map[cluster_idx] = labels[i]

df["cluster_label"] = df["cluster_idx"].map(labels_map)

# Build output
output = []
for _, r in df.iterrows():
    output.append({
        "transaction_id": int(r["transaction_id"]),
        "total_assistances": int(r["total_assistances"]),
        "total_amount": float(r["total_amount"]),
        "cluster_idx": int(r["cluster_idx"]),
        "cluster_label": r["cluster_label"]
    })


safe_name = make_safe(TARGET_BARANGAY)
out_file = os.path.join(OUTPUT_DIR, f"cluster_results_tx_{safe_name}.json")


with open(out_file, "w", encoding="utf-8") as f:
    json.dump(output, f, indent=4)

print(f"✅ Saved: {out_file} ({len(output)} transactions)")
print("🎉 DONE!")
