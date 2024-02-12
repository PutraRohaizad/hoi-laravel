<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
            [ 'name' => "Meja", 'price'=> 20],
            [ 'name' => "Almari", 'price'=> 30],
            [ 'name' => "Kerusi", 'price'=> 40],
            [ 'name' => "Katil", 'price'=> 50],
            [ 'name' => "Rak Kasut", 'price'=> 60],  
        ];

        Product::insert($seeds);
    }
}
