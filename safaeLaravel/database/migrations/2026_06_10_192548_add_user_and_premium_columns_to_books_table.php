<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();

            $table->unsignedBigInteger('reader_count')
                ->default(0);

            $table->boolean('is_premium')
                ->default(false);

            $table->boolean('premium_notified')
                ->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {

            $table->dropConstrainedForeignId('user_id');

            $table->dropColumn([
                'reader_count',
                'is_premium',
                'premium_notified'
            ]);
        });
    }
};