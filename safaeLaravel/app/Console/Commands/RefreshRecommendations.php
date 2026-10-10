<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RefreshRecommendations extends Command
{
    protected $signature = 'recommendations:refresh {--dry-run : hitung saja tanpa menulis ke database}';
    protected $description = 'Jalankan predict_batch.py untuk memperbarui tabel book_recommendations';

    public function handle(): int
    {
        $cfg = config('recommendation');

        $cmd = [
            $cfg['python'], 'predict_batch.py',
            '--env', base_path('.env'),
            '--top', (string) $cfg['top'],
            '--durasi-bagi', (string) $cfg['durasi_bagi'],
        ];
        if ($this->option('dry-run')) {
            $cmd[] = '--dry-run';
        }

        $process = new Process($cmd, $cfg['path'], null, null, $cfg['timeout']);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        if (! $process->isSuccessful()) {
            $this->error('predict_batch.py gagal. Tabel book_recommendations tidak diubah.');
            return self::FAILURE;
        }

        $this->info('Rekomendasi berhasil diperbarui.');
        return self::SUCCESS;
    }
}