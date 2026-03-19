<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@employee.com'],
            [
                'name' => 'Test Employee',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
            ]
        );
    }
}