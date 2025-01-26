<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Src\Shared\Domain\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'uuid' => Uuid::random()->value(),
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
