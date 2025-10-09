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
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('slug')->unique();

            $table->integer('year')->nullable();

            $table->integer('pages')->nullable();

            $table->string('isbn')->nullable();

            // Campo per la sinossi breve
            $table->text('short_description');

            // Campo per la sinossi estesa
            $table->text('description');

            // Campo per la casa editrice
            $table->string('publisher');

            $table->foreignId('product_id')->constrained('products')->nullOnDelete();

            $table->json('meta')->nullable();

            $table->timestamps();
        });

        Schema::create('book_genre', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
        });

        Schema::create('book_author', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('book_author_id')->constrained('book_authors')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_genre');
        Schema::dropIfExists('book_author');
    }
};
