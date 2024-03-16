<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'budi', 'password' => Hash::make('budi123'), 'email' => 'budi@gmail.com'],
            ['name' => 'john', 'password' => Hash::make('john123'), 'email' => 'john@gmail.com'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
