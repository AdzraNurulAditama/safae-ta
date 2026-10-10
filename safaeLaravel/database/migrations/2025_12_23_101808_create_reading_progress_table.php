<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reading_progress', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');

            $table->integer('duration')->default(0); // durasi baca (detik)
            $table->timestamps();

            // relasi ke users
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            // relasi ke books
            $table->foreign('book_id')
                  ->references('id')->on('books')
                  ->onDelete('cascade');

            // 1 user hanya 1 progress per buku
            $table->unique(['user_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reading_progress');
    }
};
