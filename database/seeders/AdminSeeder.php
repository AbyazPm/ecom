<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@tokoku.com'],
            [
                'name' => 'Admin Toko',
                'password' => Hash::make('admin123'),
                'is_admin' => 1
            ]
        );
    }
}
