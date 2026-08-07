<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Administrator',
                'password' => bcrypt('password'),
                'role'     => \App\Models\User::ROLE_ADMIN,
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'kasubbag@sipadu.go.id'],
            [
                'name'     => 'Kasubbag Umum dan Kepegawaian',
                'password' => bcrypt('password'),
                'role'     => \App\Models\User::ROLE_KASUBBAG,
            ]
        );
    }
}
