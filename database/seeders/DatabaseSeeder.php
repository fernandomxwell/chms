<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        try {
            User::create([
                'name' => 'Fernando',
                'email' => 'fernandomxwell@gmail.com',
                'password' => bcrypt('Admin123!'),
            ]);
        } catch (\Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
}
