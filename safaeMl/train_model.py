import argparse
import json
import os
from datetime import datetime

import joblib
import pandas as pd

from sklearn.compose import ColumnTransformer
from sklearn.dummy import DummyClassifier
from sklearn.impute import SimpleImputer
from sklearn.metrics import (
    accuracy_score,
    classification_report,
    confusion_matrix,
    f1_score,
    precision_score,
    recall_score
)
from sklearn.model_selection import (
    GridSearchCV,
    GroupShuffleSplit,
    StratifiedGroupKFold,
    StratifiedKFold,
    train_test_split
)
from sklearn.pipeline import Pipeline
from sklearn.preprocessing import OneHotEncoder, StandardScaler
from sklearn.svm import SVC
from sklearn.tree import DecisionTreeClassifier


# ==========================================
# KONFIGURASI
# ==========================================

RANDOM_STATE = 42

LABEL = "umpan_balik"

ID_COLS = ["user_id", "book_id"]

CAT_COLS = [
    "jurusan",
    "jenis_buku",
    "kategori_topik",
    "tipe_konten"
]

NUM_COLS = [
    "semester",
    "jumlah_halaman",
    "status_premium",
    "rata_durasi_lain",
    "rasio_favorit_lain",
    "jumlah_buku_lain",
    "porsi_genre_dibaca",
    "porsi_jenis_dibaca",
    "rata_durasi_genre_lain",
    "rasio_selesai",
    "total_menit_dibaca",
    "total_resume",
    "pengguna_baru"
]

K_BLEND = 5
MIN_USERS_GROUP = 10


# ==========================================
# PREPROCESSING
# ==========================================

def build_preprocessor():

    num_pipeline = Pipeline([
        (
            "isi",
            SimpleImputer(strategy="constant", fill_value=0)
        ),
        (
            "skala",
            StandardScaler()
        )
    ])

    return ColumnTransformer([
        (
            "kat",
            OneHotEncoder(handle_unknown="ignore"),
            CAT_COLS
        ),
        (
            "num",
            num_pipeline,
            NUM_COLS
        )
    ])


# ==========================================
# EVALUASI MODEL
# ==========================================

def evaluate(name, model, X_test, y_test):

    pred = model.predict(X_test)

    cm = confusion_matrix(
        y_test,
        pred,
        labels=[0, 1]
    )

    hasil = {
        "model": name,
        "akurasi": accuracy_score(y_test, pred),
        "precision": precision_score(
            y_test,
            pred,
            zero_division=0
        ),
        "recall": recall_score(
            y_test,
            pred,
            zero_division=0
        ),
        "f1": f1_score(
            y_test,
            pred,
            zero_division=0
        ),
        "TN": int(cm[0, 0]),
        "FP": int(cm[0, 1]),
        "FN": int(cm[1, 0]),
        "TP": int(cm[1, 1])
    }

    return hasil, pred


# ==========================================
# MENYIMPAN DETAIL PREDIKSI
# ==========================================

def simpan_detail_prediksi(
    df,
    test_idx,
    prediksi,
    nama_model,
    output_folder
):

    data_uji = df.iloc[test_idx].copy()

    data_uji["prediksi"] = prediksi

    data_uji["keterangan"] = data_uji.apply(
        lambda row: (
            "Benar"
            if row[LABEL] == row["prediksi"]
            else "Salah"
        ),
        axis=1
    )

    data_uji["model"] = nama_model

    kolom_detail = [
        "user_id",
        "book_id",
        "jenis_buku",
        "kategori_topik",
        LABEL,
        "prediksi",
        "keterangan",
        "sumber_data"
    ]

    # Simpan seluruh data uji
    data_uji[kolom_detail].to_csv(
        os.path.join(
            output_folder,
            f"detail_prediksi_{nama_model.lower().replace(' ', '_')}.csv"
        ),
        index=False
    )

    # Simpan khusus data asli
    if "sumber_data" in data_uji.columns:

        data_asli = data_uji[
            data_uji["sumber_data"] == "asli"
        ]

        data_asli[kolom_detail].to_csv(
            os.path.join(
                output_folder,
                f"detail_prediksi_data_asli_{nama_model.lower().replace(' ', '_')}.csv"
            ),
            index=False
        )

        print(f"\nDetail prediksi data asli - {nama_model}:")
        print(
            data_asli[kolom_detail].to_string(index=False)
        )

    return data_uji


# ==========================================
# MAIN PROGRAM
# ==========================================

def main():

    parser = argparse.ArgumentParser()

    parser.add_argument(
        "--data",
        default="data/dataset_safae_gabungan.csv"
    )

    parser.add_argument(
        "--out",
        default="models"
    )

    parser.add_argument(
        "--split",
        choices=["pengguna", "acak"],
        default="pengguna",
        help=(
            "pengguna = data pengguna yang sama tidak masuk "
            "ke data latih dan data uji sekaligus; "
            "acak = pembagian berdasarkan baris"
        )
    )

    args = parser.parse_args()

    # ======================================
    # MEMERIKSA DATASET
    # ======================================

    if not os.path.exists(args.data):
        raise SystemExit(
            f"Dataset tidak ditemukan: {args.data}"
        )

    os.makedirs(args.out, exist_ok=True)

    df = pd.read_csv(args.data)

    required_cols = (
        CAT_COLS
        + NUM_COLS
        + ID_COLS
        + [LABEL]
    )

    if "sumber_data" not in df.columns:
        raise SystemExit(
            "Kolom sumber_data tidak ditemukan. "
            "Pastikan dataset membedakan data asli dan dummy."
        )

    missing = [
        col for col in required_cols
        if col not in df.columns
    ]

    if missing:
        raise SystemExit(
            f"Kolom hilang di dataset: {missing}"
        )

    if df.empty:
        raise SystemExit("Dataset kosong.")

    if df[LABEL].isna().any():
        raise SystemExit(
            "Kolom umpan_balik memiliki nilai kosong."
        )

    df[LABEL] = df[LABEL].astype(int)

    if not set(df[LABEL].unique()).issubset({0, 1}):
        raise SystemExit(
            "Label umpan_balik hanya boleh berisi 0 dan 1."
        )

    if df[LABEL].nunique() < 2:
        raise SystemExit(
            "Dataset harus memiliki label 0 dan 1."
        )

    print("\n================================")
    print("DATASET SAFAE")
    print("================================")

    print(f"Lokasi dataset : {args.data}")
    print(f"Jumlah baris   : {len(df)}")
    print(f"Label 1        : {(df[LABEL] == 1).sum()}")
    print(f"Label 0        : {(df[LABEL] == 0).sum()}")

    print("\nJumlah data berdasarkan sumber:")
    print(df["sumber_data"].value_counts())

    print("\nDistribusi label berdasarkan jenis buku:")
    print(
        df.groupby("jenis_buku")[LABEL]
        .agg(["count", "mean"])
        .round(3)
    )

    # ======================================
    # MENENTUKAN FITUR DAN LABEL
    # ======================================

    X = df[CAT_COLS + NUM_COLS]
    y = df[LABEL]

    # ======================================
    # PEMBAGIAN DATA LATIH DAN DATA UJI
    # ======================================

    if args.split == "pengguna":

        if df["user_id"].nunique() < 6:
            raise SystemExit(
                "Jumlah pengguna terlalu sedikit untuk "
                "split pengguna dan cross-validation 5 fold."
            )

        splitter = GroupShuffleSplit(
            n_splits=1,
            test_size=0.2,
            random_state=RANDOM_STATE
        )

        train_idx, test_idx = next(
            splitter.split(
                X,
                y,
                groups=df["user_id"]
            )
        )

        X_train = X.iloc[train_idx]
        X_test = X.iloc[test_idx]

        y_train = y.iloc[train_idx]
        y_test = y.iloc[test_idx]

        groups_train = df["user_id"].iloc[train_idx]

        if y_train.nunique() < 2 or y_test.nunique() < 2:
            raise SystemExit(
                "Pembagian berdasarkan pengguna menghasilkan "
                "data latih atau data uji yang hanya memiliki "
                "satu kelas. Periksa distribusi label per pengguna."
            )

        cv = StratifiedGroupKFold(
            n_splits=5,
            shuffle=True,
            random_state=RANDOM_STATE
        )

        fit_kw = {
            "groups": groups_train
        }

        print("\nMetode pembagian: Berdasarkan pengguna")

        print(
            f"Pengguna latih: {groups_train.nunique()}"
        )

        print(
            "Pengguna uji  : "
            f"{df['user_id'].iloc[test_idx].nunique()}"
        )

    else:

        X_train, X_test, y_train, y_test = train_test_split(
            X,
            y,
            test_size=0.2,
            stratify=y,
            random_state=RANDOM_STATE
        )

        # Indeks baris asli dari data uji
        train_idx = X_train.index
        test_idx = X_test.index

        cv = StratifiedKFold(
            n_splits=5,
            shuffle=True,
            random_state=RANDOM_STATE
        )

        fit_kw = {}

        print("\nMetode pembagian: Acak berdasarkan baris")

    print(f"Jumlah data latih: {len(X_train)}")
    print(f"Jumlah data uji  : {len(X_test)}")

    # ======================================
    # MODEL YANG DIBANDINGKAN
    # ======================================

    candidates = {

        "Decision Tree": (
            DecisionTreeClassifier(
                random_state=RANDOM_STATE
            ),
            {
                "model__max_depth": [
                    3, 4, 5, 6, 8, None
                ],
                "model__min_samples_leaf": [
                    1, 5, 10, 20
                ]
            }
        ),

        "SVM": (
            SVC(
                random_state=RANDOM_STATE
            ),
            [
                {
                    "model__kernel": ["linear"],
                    "model__C": [0.1, 1, 10]
                },
                {
                    "model__kernel": ["rbf"],
                    "model__C": [0.1, 1, 10],
                    "model__gamma": [
                        "scale", 0.01, 0.1
                    ]
                }
            ]
        )

    }

    # ======================================
    # BASELINE MODEL
    # ======================================

    results = []
    fitted = {}
    cv_scores = {}

    baseline = Pipeline([
        ("prep", build_preprocessor()),
        (
            "model",
            DummyClassifier(strategy="most_frequent")
        )
    ])

    baseline.fit(X_train, y_train)

    hasil_baseline, _ = evaluate(
        "Baseline (mayoritas)",
        baseline,
        X_test,
        y_test
    )

    results.append(hasil_baseline)

    # ======================================
    # TRAINING DECISION TREE DAN SVM
    # ======================================

    for name, (classifier, parameter_grid) in candidates.items():

        print("\n================================")
        print(f"TRAINING {name.upper()}")
        print("================================")

        pipeline = Pipeline([
            ("prep", build_preprocessor()),
            ("model", classifier)
        ])

        grid_search = GridSearchCV(
            estimator=pipeline,
            param_grid=parameter_grid,
            scoring="f1",
            cv=cv,
            n_jobs=-1,
            error_score="raise"
        )

        grid_search.fit(
            X_train,
            y_train,
            **fit_kw
        )

        best_model = grid_search.best_estimator_

        fitted[name] = best_model
        cv_scores[name] = grid_search.best_score_

        hasil, prediksi = evaluate(
            name,
            best_model,
            X_test,
            y_test
        )

        hasil["cv_f1"] = grid_search.best_score_

        hasil["param_terbaik"] = json.dumps(
            {
                key.replace("model__", ""): value
                for key, value in grid_search.best_params_.items()
            },
            default=str
        )

        results.append(hasil)

        print("\nParameter terbaik:")
        print(grid_search.best_params_)

        print(
            f"CV F1-score: {grid_search.best_score_:.4f}"
        )

        print("\nClassification Report:")
        print(
            classification_report(
                y_test,
                prediksi,
                labels=[0, 1],
                target_names=[
                    "Kurang cocok (0)",
                    "Cocok (1)"
                ],
                zero_division=0
            )
        )

        print("Confusion Matrix:")
        print(
            confusion_matrix(
                y_test,
                prediksi,
                labels=[0, 1]
            )
        )

        # Simpan detail prediksi untuk masing-masing model
        simpan_detail_prediksi(
            df,
            test_idx,
            prediksi,
            name,
            args.out
        )

    # ======================================
    # MENENTUKAN MODEL TERBAIK
    # ======================================

    best_name = max(
        cv_scores,
        key=cv_scores.get
    )

    best_model = fitted[best_name]

    print("\n================================")
    print("MODEL TERBAIK")
    print("================================")

    print(f"Model terbaik: {best_name}")
    print(f"CV F1-score  : {cv_scores[best_name]:.4f}")

    # ======================================
    # EVALUASI BERDASARKAN SUMBER DATA
    # ======================================

    evaluasi_sumber = None

    if "sumber_data" in df.columns:

        prediksi_best = best_model.predict(X_test)

        data_uji = df.iloc[test_idx].copy()
        data_uji["prediksi"] = prediksi_best

        baris_sumber = []

        for sumber in sorted(
            data_uji["sumber_data"].dropna().unique()
        ):

            subset = data_uji[
                data_uji["sumber_data"] == sumber
            ]

            if subset[LABEL].nunique() < 2:
                f1_sumber = None
            else:
                f1_sumber = f1_score(
                    subset[LABEL],
                    subset["prediksi"],
                    zero_division=0
                )

            baris_sumber.append({
                "sumber_data": sumber,
                "jumlah_data": len(subset),
                "akurasi": accuracy_score(
                    subset[LABEL],
                    subset["prediksi"]
                ),
                "f1": f1_sumber
            })

        evaluasi_sumber = pd.DataFrame(baris_sumber)

        print("\nEvaluasi berdasarkan sumber data:")
        print(evaluasi_sumber.round(3).to_string(index=False))

    # ======================================
    # MENYIMPAN MODEL
    # ======================================

    model_path = os.path.join(
        args.out,
        "model.joblib"
    )

    joblib.dump(
        {
            "model": best_model,
            "model_name": best_name,
            "cat_cols": CAT_COLS,
            "num_cols": NUM_COLS,
            "k_blend": K_BLEND,
            "min_users_group": MIN_USERS_GROUP,
            "dilatih_pada": datetime.now().isoformat(
                timespec="seconds"
            ),
            "jumlah_baris_latih": len(X_train),
            "dataset": args.data
        },
        model_path
    )

    # ======================================
    # MENYIMPAN HASIL EVALUASI
    # ======================================

    hasil_df = pd.DataFrame(results)

    hasil_csv = os.path.join(
        args.out,
        "hasil_evaluasi.csv"
    )

    hasil_df.to_csv(
        hasil_csv,
        index=False
    )

    hasil_txt = os.path.join(
        args.out,
        "hasil_evaluasi.txt"
    )

    with open(
        hasil_txt,
        "w",
        encoding="utf-8"
    ) as file:

        file.write("HASIL EVALUASI MODEL REKOMENDASI SAFAE\n")
        file.write("=" * 50 + "\n\n")

        file.write(f"Dataset: {args.data}\n")
        file.write(f"Jumlah data: {len(df)}\n")
        file.write(f"Metode split: {args.split}\n")
        file.write(f"Jumlah data latih: {len(X_train)}\n")
        file.write(f"Jumlah data uji: {len(X_test)}\n\n")

        file.write("DISTRIBUSI LABEL\n")
        file.write("-" * 30 + "\n")
        file.write(
            df[LABEL].value_counts().sort_index().to_string()
        )
        file.write("\n\n")

        file.write("PERBANDINGAN MODEL\n")
        file.write("-" * 30 + "\n")
        file.write(
            hasil_df.to_string(index=False)
        )
        file.write("\n\n")

        file.write(f"MODEL TERBAIK: {best_name}\n")
        file.write(
            f"CV F1-score: {cv_scores[best_name]:.4f}\n"
        )

        if evaluasi_sumber is not None:
            file.write("\nEVALUASI BERDASARKAN SUMBER DATA\n")
            file.write("-" * 30 + "\n")
            file.write(
                evaluasi_sumber.to_string(index=False)
            )
            file.write("\n")

    # ======================================
    # SELESAI
    # ======================================

    print("\n================================")
    print("TRAINING SELESAI")
    print("================================")

    print(f"Model tersimpan : {model_path}")
    print(f"Hasil CSV       : {hasil_csv}")
    print(f"Hasil TXT       : {hasil_txt}")

    print("\nFile detail prediksi:")
    print("- models/detail_prediksi_decision_tree.csv")
    print("- models/detail_prediksi_svm.csv")
    print("- models/detail_prediksi_data_asli_decision_tree.csv")
    print("- models/detail_prediksi_data_asli_svm.csv")


if __name__ == "__main__":
    main()
