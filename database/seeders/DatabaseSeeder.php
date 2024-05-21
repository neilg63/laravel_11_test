<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $products = [
            [
                'sku' => 'TM123456678',
                'name' => 'Tomatoes',
                'description' => 'Lorem ipsum... One',
                'currency' => 'GBP',
                'price' => 200
            ],
            [
                'sku' => 'CB123456678',
                'name' => 'Cabbage',
                'description' => 'Lorem ipsum... Two',
                'currency' => 'GBP',
                'price' => 100
            ],
            [
                'sku' => 'CA123456678',
                'name' => 'Carrots',
                'description' => 'Lorem ipsum... Three',
                'currency' => 'GBP',
                'price' => 25
            ]
        ];

        foreach ($products as $row) {
            Product::create($row);
        }
    }
}
