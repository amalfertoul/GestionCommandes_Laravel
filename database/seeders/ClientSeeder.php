<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    public function run()
{
    DB::table('clients')->insert([
        ['nom' => 'Dupont', 'prenom' => 'Jean'],
        ['nom' => 'Martin', 'prenom' => 'Claire'],
        ['nom' => 'Bernard', 'prenom' => 'Paul'],
        ['nom' => 'Lemoine', 'prenom' => 'Sophie'],
    ]);
}

}
