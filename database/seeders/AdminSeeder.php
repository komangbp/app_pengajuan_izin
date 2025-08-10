<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_verified' => true
        ]);

        // contoh verifikator
        User::create([
            'name' => 'Verifikator Satu',
            'email' => 'verif@example.com',
            'password' => Hash::make('verif123'),
            'role' => 'verifikator',
            'is_verified' => true
        ]);
    }
}
