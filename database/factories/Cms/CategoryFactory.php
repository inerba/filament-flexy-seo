<?php

namespace Database\Factories\Cms;

use App\Models\Cms\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // For each locale, generate a random category name
        $name = [];
        foreach (get_supported_locales() as $locale) {
            $name[$locale] = fake()->words(3, true);
        }

        return [
            'name' => $name,

            // Generate a unique slug based on the name in the default locale
            'slug' => fake()->unique()->slug(),
            'extras' => [
                'post_per_page' => 12,
            ],
        ];
    }
}
