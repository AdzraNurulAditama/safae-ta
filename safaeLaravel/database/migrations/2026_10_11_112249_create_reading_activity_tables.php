<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Catatan Aktivitas Membaca (Waktu & Kalender)
        if (!Schema::hasTable('reading_sessions')) {
            Schema::create('reading_sessions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('book_id')->nullable()->constrained()->nullOnDelete();
                $table->integer('duration_minutes')->default(0); // Menit membaca
                $table->integer('pages_read')->default(0);
                $table->date('read_date');
                $table->timestamps();
            });
        }

        // 2. Tabel Target Membaca Bulanan & Mingguan
        if (!Schema::hasTable('reading_goals')) {
            Schema::create('reading_goals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->integer('target_books_monthly')->default(5);
                $table->integer('target_days_weekly')->default(5);
                $table->integer('year')->default(2026);
                $table->integer('month')->default(10);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reading_sessions');
        Schema::dropIfExists('reading_goals');
    }
};