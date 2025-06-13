<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = Currency::all();

        \Log::info($currencies);

        if($currencies->isEmpty()) {
            $this->command->error('No currencies found. Please seed currencies first.');
            return;
        }
        
        $products = [
            [
                'name' => 'Baby Onesie',
                'description' => 'Soft cotton baby onesie, suitable for newborns.',
                'price' => 15.99,
                'tax_cost' => 1.5,
                'manufacturing_cost' => 5.0,
            ],
            [
                'name' => 'Baby Blanket',
                'description' => 'Warm and cozy baby blanket made with organic materials.',
                'price' => 25.50,
                'tax_cost' => 2.0,
                'manufacturing_cost' => 7.5,
            ],
            [
                'name' => 'Baby Bottle',
                'description' => 'BPA-free baby bottle with anti-colic system.',
                'price' => 10.00,
                'tax_cost' => 1.0,
                'manufacturing_cost' => 3.0,
            ],
        ];

        $currencyCount = $currencies->count();

        foreach ($products as $index => $product) {

            $currency = $currencies[$index % $currencyCount];
            $product['currency_id'] = $currency->id;

            $result = Product::create($product);
            
            \Log::info($result);
        }
    }
}
