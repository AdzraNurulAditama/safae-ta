<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('books', 'jumlah_halaman')) {
            Schema::table('books', function (Blueprint $table) {
                $table->integer('jumlah_halaman')->default(1)->after('year');
            });
        }
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('jumlah_halaman');
        });
    }
};