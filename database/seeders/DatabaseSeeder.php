<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role admin selalu ada tiap kali deploy
        User::updateOrCreate(
            ['email' => 'muhamademiralfani@gmail.com'],
            [
                'name' => 'Emir Admin',
                'password' => Hash::make('admin123'), // Ganti ini nanti
                'role' => 'admin',
            ]
        );
    }
}