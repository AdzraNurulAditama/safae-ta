
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('point_histories', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('point_histories', function (Blueprint $table) {
            $table->dropColumn(['type', 'description']);
        });
    }
};
