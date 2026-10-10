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
    Schema::create('chapters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
        $table->integer('chapter_number');
        $table->string('title');
        $table->longText('content');
        $table->string('image')->nullable(); // Untuk foto ilustrasi per chapter
        $table->enum('status', ['draft', 'published'])->default('draft');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
