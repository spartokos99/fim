<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Nico',
                'email' => 'nico@dev.com',
                'password' => bcrypt('1'),
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'name'=> 'Matts',
                'email'=> 'matts@dev.com',
                'password'=> bcrypt('nudel'),
                'created_at' => now(),
                'updated_at'=> now(),
            ]
        ]);
    }
}
