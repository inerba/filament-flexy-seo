<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()
            ->create([
                'email' => config('cms.default_user.email'),
                'password' => Hash::make(config('cms.default_user.password')),
                'name' => config('cms.default_user.name'),
            ]);
    }
}
