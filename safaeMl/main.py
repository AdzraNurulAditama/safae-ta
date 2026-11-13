import os
from contextlib import asynccontextmanager
from types import SimpleNamespace
 
import joblib
from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, Field
 
import predict_batch as pb
 
MODEL_PATH = os.getenv("SAFAE_MODEL", "models/model.joblib")
ENV_PATH = os.getenv("SAFAE_ENV")          # path .env Laravel (atau pakai SAFAE_DB_URL)
DB_URL = os.getenv("SAFAE_DB_URL")
DURASI_BAGI = float(os.getenv("SAFAE_DURASI_BAGI", "1"))   # 60 kalau duration di DB dalam detik
 
state = {}
 
 
@asynccontextmanager
async def lifespan(app: FastAPI):
    # dijalankan sekali saat service start: model di-load ke memori dan dipakai ulang tiap request
    if not (ENV_PATH or DB_URL):
        raise RuntimeError("Isi SAFAE_ENV (path .env Laravel) atau SAFAE_DB_URL sebelum menjalankan service.")
    state["bundle"] = joblib.load(MODEL_PATH)
    state["engine"] = pb.make_engine(SimpleNamespace(env=ENV_PATH, db_url=DB_URL))
    yield
    state["engine"].dispose()
 
 
app = FastAPI(title="Safae Recommendation API", lifespan=lifespan)
 
 
class RecommendRequest(BaseModel):
    user_id: int
    top_n: int = Field(1000, ge=1, le=5000)
 
 
@app.post("/recommend")
def recommend(req: RecommendRequest):
    """Hitung ulang rekomendasi satu pengguna dan simpan ke book_recommendations.
    Dibuat `def` (bukan `async def`) supaya FastAPI menjalankannya di threadpool dan tidak memblokir service."""
    try:
        jumlah = pb.refresh_pengguna(
            state["engine"], state["bundle"], req.user_id,
            top_n=req.top_n, durasi_bagi=DURASI_BAGI,
        )
    except Exception as ex:
        raise HTTPException(status_code=500, detail=f"Gagal menghitung rekomendasi: {ex}")
    if jumlah is None:
        raise HTTPException(status_code=404, detail=f"user_id {req.user_id} tidak ditemukan")
    return {"status": "ok", "user_id": req.user_id, "jumlah_rekomendasi": jumlah}
 
 
@app.get("/health")
def health():
    b = state.get("bundle", {})
    return {"status": "ok", "model": b.get("model_name"), "dilatih_pada": b.get("dilatih_pada")}