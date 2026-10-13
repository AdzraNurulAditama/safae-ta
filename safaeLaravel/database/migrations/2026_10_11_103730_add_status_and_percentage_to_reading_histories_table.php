<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reading_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('reading_histories', 'status')) {
                $table->enum('status', ['Belum Dibaca', 'Sedang Dibaca', 'Selesai Dibaca'])->default('Sedang Dibaca')->after('progress');
            }
            if (!Schema::hasColumn('reading_histories', 'progress_percentage')) {
                $table->decimal('progress_percentage', 5, 2)->default(0.00)->after('progress');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reading_histories', function (Blueprint $table) {
            $table->dropColumn(['status', 'progress_percentage']);
        });
    }
};