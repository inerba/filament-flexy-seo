<?php

namespace Database\Factories\Cms;

use App\Models\Cms\Article;
use App\Models\Cms\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // For each locale, generate a random title and content
        $title = [];
        $content = [];
        $excerpt = [];
        foreach (get_supported_locales() as $locale) {
            $title[$locale] = $this->faker->words(3, true);
            $content[$locale] = $this->faker->paragraphs(5, true);
            $excerpt[$locale] = Str::limit($content[$locale], 300);
        }

        return [
            'title' => $title,
            'slug' => $this->faker->unique()->slug(),
            'content' => $content,
            'excerpt' => $excerpt,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'category_id' => Category::factory(),
            'user_id' => 1,
        ];
    }
}
