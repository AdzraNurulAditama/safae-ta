<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('book_recommendations')) {
            return;
        }

        Schema::create('book_recommendations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->decimal('skor', 6, 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_recommendations');
    }
};