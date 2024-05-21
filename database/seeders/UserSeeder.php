<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test User One',
                'email' => 'test1@example.com',
                'password' => 'secret123A'
            ],
            [
                'name' => 'Test User Two',
                'email' => 'test2@example.com',
                'password' => 'secret123B'
            ],
            [
                'name' => 'Test User Three',
                'email' => 'test3@example.com',
                'password' => 'secret123C'
            ]
        ];
        foreach ($users as $row) {
            User::factory()->create($row);
        }
    }
}
