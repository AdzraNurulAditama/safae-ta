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
    Schema::table('book_recommendations', function (Blueprint $table) {
        $table->unsignedInteger('urutan')->nullable()->after('skor');
    });
}

public function down(): void
{
    Schema::table('book_recommendations', function (Blueprint $table) {
        $table->dropColumn('urutan');
    });
}
};
