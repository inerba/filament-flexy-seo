<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $title = fake()->words(3, true);

        // date example: 12-15 Aprile 2025
        // Generate a DateTime between +1 week and +1 year
        $start = fake()->dateTimeBetween('+1 week', '+1 year');

        // Sometimes generate a range (e.g., 12-15 Aprile 2025), sometimes a single date (e.g., 3 maggio 2025)
        $isRange = fake()->boolean(30); // 30% chance to be a range

        $monthsIt = [
            1 => 'gennaio',
            2 => 'febbraio',
            3 => 'marzo',
            4 => 'aprile',
            5 => 'maggio',
            6 => 'giugno',
            7 => 'luglio',
            8 => 'agosto',
            9 => 'settembre',
            10 => 'ottobre',
            11 => 'novembre',
            12 => 'dicembre',
        ];

        if ($isRange) {
            // range length between 1 and 7 days
            $length = fake()->numberBetween(1, 7);
            $end = (clone $start)->modify("+{$length} days");

            // If start and end are in same month and year, use format '12-15 aprile 2025'
            if ($start->format('m') === $end->format('m') && $start->format('Y') === $end->format('Y')) {
                $dayStart = (int) $start->format('j');
                $dayEnd = (int) $end->format('j');
                $monthName = $monthsIt[(int) $start->format('n')];
                $year = $start->format('Y');

                $date = "{$dayStart}-{$dayEnd} {$monthName} {$year}";
            } else {
                // If month or year differ, format as '12 aprile 2025 - 2 maggio 2025'
                $date = $start->format('j').' '.$monthsIt[(int) $start->format('n')].' '.$start->format('Y')
                    .' - '.$end->format('j').' '.$monthsIt[(int) $end->format('n')].' '.$end->format('Y');
            }
        } else {
            // single date like '3 maggio 2025'
            $date = (int) $start->format('j').' '.$monthsIt[(int) $start->format('n')].' '.$start->format('Y');
        }

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraph(4),
            'location' => fake()->address(),
            'date' => $date,
            'published_at' => fake()->boolean(80) ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'excerpt' => fake()->paragraph(1),
            'subtitle' => fake()->sentence(),
        ];
    }
}
