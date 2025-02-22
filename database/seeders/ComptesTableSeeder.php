<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ComptesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('comptes')->insert([
            [
                'login' => 'amal',
                'gmail' => 'fertoulamal@gmail.com',
                'mot_passe' => Hash::make('1234567'),
                'profil' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'login' => 'kibo',
                'gmail' => 'kibofilmprod@gmail.com',
                'mot_passe' => Hash::make('1234567'),
                'profil' => 'client',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
