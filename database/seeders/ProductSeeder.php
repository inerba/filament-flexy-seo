<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()
            ->hasVariants(5)
            ->count(10)
            ->create();

        $this->command?->info('Seeded 10 products.');
    }
}
