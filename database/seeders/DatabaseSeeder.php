<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@mail.com',
        ]);

        Chirp::factory(50)->recycle($users)->create();
    }
}
