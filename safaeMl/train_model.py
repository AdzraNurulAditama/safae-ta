import argparse
import json
import os
from datetime import datetime
 
import joblib
import pandas as pd
from sklearn.compose import ColumnTransformer
from sklearn.dummy import DummyClassifier
from sklearn.metrics import (accuracy_score, classification_report, confusion_matrix,
                             f1_score, precision_score, recall_score)
from sklearn.model_selection import GridSearchCV, StratifiedKFold, train_test_split
from sklearn.pipeline import Pipeline
from sklearn.preprocessing import OneHotEncoder, StandardScaler
from sklearn.svm import SVC
from sklearn.tree import DecisionTreeClassifier
 
RANDOM_STATE = 42
LABEL = "cocok"
ID_COLS = ["user_id", "book_id"]                      # identitas: dibuang saat training
CAT_COLS = ["jurusan", "jenis_buku", "kategori_topik", "tipe_konten"]
NUM_COLS = ["semester", "jumlah_halaman", "status_premium", "rata_durasi_lain",
            "rasio_favorit_lain", "jumlah_buku_lain", "porsi_genre_dibaca",
            "porsi_jenis_dibaca", "rata_durasi_genre_lain"]
 
 
def build_preprocessor():
    # kategorikal -> one-hot ; numerik -> StandardScaler (wajib untuk SVM, tidak merugikan DT)
    return ColumnTransformer([
        ("kat", OneHotEncoder(handle_unknown="ignore"), CAT_COLS),
        ("num", StandardScaler(), NUM_COLS),
    ])
 
 
def evaluate(name, model, X_test, y_test):
    pred = model.predict(X_test)
    cm = confusion_matrix(y_test, pred, labels=[0, 1])
    return {
        "model": name,
        "akurasi": accuracy_score(y_test, pred),
        "precision": precision_score(y_test, pred, zero_division=0),
        "recall": recall_score(y_test, pred, zero_division=0),
        "f1": f1_score(y_test, pred, zero_division=0),
        "TN": int(cm[0, 0]), "FP": int(cm[0, 1]), "FN": int(cm[1, 0]), "TP": int(cm[1, 1]),
    }, pred
 
 
def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--data", default="data/dataset_dummy_safae.csv")
    ap.add_argument("--out", default="models")
    args = ap.parse_args()
 
    if not os.path.exists(args.data):
        raise SystemExit(f"Dataset tidak ditemukan: {args.data}")
    os.makedirs(args.out, exist_ok=True)
 
    # ---------- 1. Baca data & cek ----------
    df = pd.read_csv(args.data)
    missing = [c for c in CAT_COLS + NUM_COLS + ID_COLS + [LABEL] if c not in df.columns]
    if missing:
        raise SystemExit(f"Kolom hilang di dataset: {missing}")
    print(f"Data: {len(df)} baris | cocok=1: {df[LABEL].mean():.1%}")
    print("Proporsi cocok=1 per jenis buku:", df.groupby("jenis_buku")[LABEL].mean().round(3).to_dict())
 
    X = df[CAT_COLS + NUM_COLS]
    y = df[LABEL]
 
    # ---------- 2. Split 80:20, stratifikasi label ----------
    X_train, X_test, y_train, y_test = train_test_split(
        X, y, test_size=0.25, stratify=y, random_state=RANDOM_STATE)
    print(f"Latih: {len(X_train)} | Uji: {len(X_test)}")
 
    # ---------- 3. Model + pencarian hyperparameter (cross-validation hanya pada data latih) ----------
    cv = StratifiedKFold(n_splits=5, shuffle=True, random_state=RANDOM_STATE)
    candidates = {
        "Decision Tree": (
            DecisionTreeClassifier(random_state=RANDOM_STATE),
            {"model__max_depth": [3, 4, 5, 6, 8, None],
             "model__min_samples_leaf": [1, 5, 10, 20]},
        ),
        "SVM": (
            SVC(random_state=RANDOM_STATE),   # skor ranking nanti dari decision_function()
            {"model__kernel": ["rbf", "linear"],
             "model__C": [0.1, 1, 10],
             "model__gamma": ["scale", 0.01, 0.1]},
        ),
    }
 
    results, fitted, cv_scores = [], {}, {}
 
    # baseline: selalu menebak kelas mayoritas (pembanding minimum)
    base = DummyClassifier(strategy="most_frequent").fit(X_train, y_train)
    r, _ = evaluate("Baseline (mayoritas)", base, X_test, y_test)
    results.append(r)
 
    for name, (clf, grid) in candidates.items():
        pipe = Pipeline([("prep", build_preprocessor()), ("model", clf)])
        gs = GridSearchCV(pipe, grid, scoring="f1", cv=cv, n_jobs=-1)
        gs.fit(X_train, y_train)
        fitted[name] = gs.best_estimator_
        cv_scores[name] = gs.best_score_
        r, pred = evaluate(name, gs.best_estimator_, X_test, y_test)
        r["cv_f1"] = gs.best_score_
        r["param_terbaik"] = json.dumps({k.replace("model__", ""): v for k, v in gs.best_params_.items()},
                                        default=str)
        results.append(r)
        print(f"\n=== {name} ===")
        print("Parameter terbaik:", r["param_terbaik"], f"| CV F1: {gs.best_score_:.3f}")
        print(classification_report(y_test, pred, target_names=["kurang cocok (0)", "cocok (1)"], zero_division=0))
 
    # ---------- 4. Pilih model terbaik berdasarkan CV F1 (bukan data uji) ----------
    best_name = max(cv_scores, key=cv_scores.get)
    best_model = fitted[best_name]
    print(f"\nModel terbaik (berdasar CV F1): {best_name}")
 
    # ---------- 5. Simpan ----------
    joblib.dump({
        "model": best_model,
        "model_name": best_name,
        "cat_cols": CAT_COLS,
        "num_cols": NUM_COLS,
        "dilatih_pada": datetime.now().isoformat(timespec="seconds"),
        "jumlah_baris_latih": len(X_train),
    }, os.path.join(args.out, "model.joblib"))
 
    res = pd.DataFrame(results)
    res.to_csv(os.path.join(args.out, "hasil_evaluasi.csv"), index=False)
 
    show = res[["model", "akurasi", "precision", "recall", "f1", "TN", "FP", "FN", "TP"]].round(3)
    with open(os.path.join(args.out, "hasil_evaluasi.txt"), "w", encoding="utf-8") as f:
        f.write(f"Dataset: {args.data} ({len(df)} baris)\n")
        f.write(f"Split: 80% latih / 20% uji, stratifikasi, random_state={RANDOM_STATE}\n")
        f.write("Hyperparameter: GridSearchCV 5-fold pada data latih, skor F1\n\n")
        f.write(show.to_string(index=False))
        f.write(f"\n\nModel terbaik (CV F1): {best_name}\n")
        f.write("Catatan: TN/FP/FN/TP dihitung pada data uji; kelas positif = cocok (1).\n")
    print("\n" + show.to_string(index=False))
    print(f"\nTersimpan di folder '{args.out}/': model.joblib, hasil_evaluasi.txt, hasil_evaluasi.csv")
 
 
if __name__ == "__main__":
    main()