<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengecekan agar tidak error jika tabel sudah ada di database
        if (!Schema::hasTable('book_recommendations')) {
            Schema::create('book_recommendations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('book_id')->constrained()->cascadeOnDelete();
                $table->decimal('skor', 6, 4);
                $table->timestamps();

                $table->unique(['user_id', 'book_id']);
                $table->index(['user_id', 'skor']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('book_recommendations');
    }
};