<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('username')->unique();   // ⭐ TAMBAHKAN INI
        $table->string('nama_depan')->nullable();  // opsional
        $table->string('nama_belakang')->nullable();
        $table->string('telepon')->nullable();
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    });
}

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
