<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommandeProduitSeeder extends Seeder
{
    public function run()
{
    DB::table('commande_produit')->insert([
        ['commande_id' => 1, 'produit_id' => 1, 'qte_cmd' => 2],
        ['commande_id' => 1, 'produit_id' => 3, 'qte_cmd' => 1],
        ['commande_id' => 2, 'produit_id' => 2, 'qte_cmd' => 3],
        ['commande_id' => 2, 'produit_id' => 4, 'qte_cmd' => 1],
        ['commande_id' => 3, 'produit_id' => 1, 'qte_cmd' => 1],
        ['commande_id' => 3, 'produit_id' => 2, 'qte_cmd' => 2],
        ['commande_id' => 4, 'produit_id' => 3, 'qte_cmd' => 5],
        ['commande_id' => 4, 'produit_id' => 4, 'qte_cmd' => 2],
    ]);
}

}
