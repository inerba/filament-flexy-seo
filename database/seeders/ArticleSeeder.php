<?php

namespace Database\Seeders;

use App\Models\Cms\Article;
use App\Models\Cms\Category;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // remove all existing records to avoid duplication no truncate to preserve relations
        Article::query()->delete();
        Category::query()->delete();

        // display message
        $this->command->info('Eliminati articoli e categorie esistenti.');

        // Category::factory(5)->create();
        $categories = [
            [
                'name' => ['it' => 'MAKEUP'],
                'slug' => 'makeup',
            ],
            [
                'name' => ['it' => 'FITNESS'],
                'slug' => 'fitness',
            ],
            [
                'name' => ['it' => 'WELLNESS'],
                'slug' => 'wellness',
            ],
            [
                'name' => ['it' => 'NUTRIZIONE'],
                'slug' => 'nutrizione',
            ],
            [
                'name' => ['it' => 'HAIRCARE'],
                'slug' => 'haircare',
            ],
            [
                'name' => ['it' => 'MODA'],
                'slug' => 'moda',
            ],
            [
                'name' => ['it' => 'CHI SIAMO'],
                'slug' => 'chi-siamo',
            ],
        ];

        foreach ($categories as $category) {
            // Explicitly check for existing category to avoid unique constraint errors
            $existing = Category::where('slug', $category['slug'])->first();

            if ($existing) {
                // Update name/extras if needed
                $existing->update($category);
            } else {
                Category::create($category);
            }
        }

        $this->command->info('Ho creato '.count($categories).' categorie.');

        $this->command->info('Creazione di 20 articoli con immagini di copertina...');
        $articles = Article::factory(20)->sequence(fn ($sequence) => [
            'user_id' => 1,
            'category_id' => Category::pluck('id')->random(),
            'extras' => [
                'show_featured_image' => true,
                'content_settings' => [
                    'dropcap' => 1,
                ],
            ],
        ])->create();

        // Create a progress bar to show media processing progress in the console
        $output = $this->command?->getOutput();
        if ($output) {
            $bar = $output->createProgressBar($articles->count());
            $bar->start();

            foreach ($articles as $article) {
                try {
                    $article->addMediaFromUrl('https://picsum.photos/800/400')
                        ->toMediaCollection('featured_image');
                } catch (\Exception $e) {
                    // Ignore failed downloads but continue the progress
                }

                $bar->advance();
            }

            $bar->finish();
        } else {
            // Fallback: process without progress bar
            $articles->each(function (Article $article) {
                try {
                    $article->addMediaFromUrl('https://picsum.photos/800/400')
                        ->toMediaCollection('featured_image');
                } catch (\Exception $e) {
                }
            });
        }

        $this->command->info('Ho creato '.$articles->count().' articoli.');

    }
}
