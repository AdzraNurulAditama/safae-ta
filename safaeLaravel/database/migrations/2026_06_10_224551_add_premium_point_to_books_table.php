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
    Schema::table('books', function (Blueprint $table) {

        $table->integer('premium_point')
            ->default(100)
            ->after('is_premium');

    });
}

public function down(): void
{
    Schema::table('books', function (Blueprint $table) {

        $table->dropColumn('premium_point');

    });
}
};
