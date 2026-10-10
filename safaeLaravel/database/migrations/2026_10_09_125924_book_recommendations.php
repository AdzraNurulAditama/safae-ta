<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->decimal('skor', 6, 4);          // 0..1, makin tinggi makin cocok
            $table->timestamps();

            $table->unique(['user_id', 'book_id']);
            $table->index(['user_id', 'skor']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_recommendations');
    }
};