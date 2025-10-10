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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->json('title');

            $table->json('subtitle')->nullable();

            $table->json('location');
            $table->json('date');

            $table->string('slug');
            $table->json('content');
            $table->json('excerpt')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->json('extras')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
