<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('book_authors', function (Blueprint $table) {
            // add nullable slug first so we can populate it
            $table->string('slug')->nullable()->after('name');
        });

        // Populate slugs from name and ensure uniqueness
        $authors = DB::table('book_authors')->select('id', 'name')->get();

        $existing = [];

        foreach ($authors as $author) {
            $base = Str::slug($author->name ?: 'author-'.$author->id);
            $slug = $base;
            $i = 1;

            // ensure uniqueness across existing and DB
            while (in_array($slug, $existing, true) || DB::table('book_authors')->where('slug', $slug)->exists()) {
                $slug = $base.'-'.$i++;
            }

            $existing[] = $slug;

            DB::table('book_authors')->where('id', $author->id)->update(['slug' => $slug]);
        }

        Schema::table('book_authors', function (Blueprint $table) {
            // make slug unique and not nullable
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_authors', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
