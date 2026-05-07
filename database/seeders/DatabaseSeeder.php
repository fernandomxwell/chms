<?php

namespace Database\Seeders;

use App\Models\Role;
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
            $superAdmin = Role::firstOrCreate(['name' => 'super admin']);

            User::firstOrCreate(
                ['email' => 'fernandomxwell@gmail.com'],
                [
                    'name' => 'Fernando',
                    'password' => bcrypt('Admin123!'),
                    'role_id' => $superAdmin->id,
                ]
            );
        } catch (\Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
}
