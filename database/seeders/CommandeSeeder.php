<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommandeSeeder extends Seeder
{
    public function run()
    {
        DB::table('commandes')->insert([
            ['date' => '2025-02-07', 'client_id' => 1],
            ['date' => '2025-02-08', 'client_id' => 2],
            ['date' => '2025-02-09', 'client_id' => 3],
            ['date' => '2025-02-10', 'client_id' => 4],
        ]);
    }

}
