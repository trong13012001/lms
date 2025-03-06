<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'admin',
            'name' => 'Quản trị viên',
            'email' => 'admin@thanglong.edu.vn',
            'password' => Hash::make('123456'), // password
        ]);

        $user->assignRole('admin');
    }
}
