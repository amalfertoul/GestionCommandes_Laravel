<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Produitseeder extends Seeder
{
    public function run()
{
    DB::table('produits')->insert([
        ['nom' => 'Produit A', 'qte_stock' => 100, 'prix' => 19.99],
        ['nom' => 'Produit B', 'qte_stock' => 50, 'prix' => 29.99],
        ['nom' => 'Produit C', 'qte_stock' => 200, 'prix' => 9.99],
        ['nom' => 'Produit D', 'qte_stock' => 30, 'prix' => 39.99],
    ]);
}

}


