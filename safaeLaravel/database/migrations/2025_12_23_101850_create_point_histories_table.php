<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->integer('points');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('book_id')->references('id')->on('books')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_histories');
    }
};
