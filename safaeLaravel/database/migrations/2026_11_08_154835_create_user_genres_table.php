
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_genres', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('genre');

            $table->timestamps();

            // Mencegah genre yang sama dipilih dua kali oleh pengguna
            $table->unique(['user_id', 'genre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_genres');
    }
};
