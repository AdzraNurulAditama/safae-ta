<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('social_media')->nullable()->after('username');
        $table->text('bio')->nullable()->after('social_media');
        $table->string('foto_profil')->nullable()->after('bio');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['social_media', 'bio', 'foto_profil']);
    });
}
};
