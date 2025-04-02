<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'user']);

        $manualUser = User::create([
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => bcrypt('123456789'),
        ]);

        $manualUser->assignRole($role);

        User::factory(15)->create()->each(function ($user) use ($role) {
            $user->assignRole($role);
        });

        $manualUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $manualUser->assignRole($adminRole);
    }
}
