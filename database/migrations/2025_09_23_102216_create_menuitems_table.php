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
        Schema::create('menuitems', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('type')->default('link');
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->integer('parent_id')->default(-1)->index(); // Must default to -1!
            $table->integer('model_id')->nullable()->index();
            $table->integer('order')->default(0);

            $table->text('url')->nullable();
            $table->string('target')->nullable();
            $table->json('extras')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menuitems');
    }
};
