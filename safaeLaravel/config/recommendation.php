<?php

// Nilai diambil dari .env. Contoh isi .env:
//   ML_PYTHON=C:\safae-ml\venv\Scripts\python.exe      (Windows)
//   ML_PYTHON=/home/user/safae-ml/venv/bin/python      (Linux/Mac)
//   ML_PATH=C:\safae-ml
//   ML_DURASI_BAGI=1        (isi 60 jika reading_progress.duration disimpan dalam detik)
return [
    'python'      => env('ML_PYTHON', 'python'),
    'path'        => env('ML_PATH', base_path('../safae-ml')),
    'durasi_bagi' => env('ML_DURASI_BAGI', 1),
    'top'         => env('ML_TOP', 20),
    'timeout'     => 600, // detik
];