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

            $table->foreignId('author_id')->constrained('authors');

            $table->integer('year');

            $table->integer('pages');

            $table->string('isbn');

            // Campo per la sinossi breve
            $table->text('short_description');

            // Campo per la sinossi estesa
            $table->text('description');

            // Campo per la casa editrice
            $table->string('publisher');

            // Campo per il prezzo in centesimi
            $table->integer('price');

            $table->json('meta')->nullable();

            $table->timestamps();
        });

        Schema::create('book_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
