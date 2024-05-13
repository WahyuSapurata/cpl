<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => 'admin',
                'password' => Hash::make('<>password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['username' => 'operator'],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => 'operator',
                'password' => Hash::make('<>password'),
                'role' => 'operator',
            ]
        );

        User::updateOrCreate(
            ['username' => 'kajur'],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => 'kajur',
                'password' => Hash::make('<>password'),
                'role' => 'kajur',
            ]
        );

        User::updateOrCreate(
            ['username' => 'lpm'],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => 'lpm',
                'password' => Hash::make('<>password'),
                'role' => 'lpm',
            ]
        );
    }
}
