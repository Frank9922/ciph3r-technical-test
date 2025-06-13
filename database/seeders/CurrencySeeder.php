<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['name' => 'US Dollar',    'symbol' => '$',  'exchange_rate' => 1.00],
            ['name' => 'Euro',         'symbol' => '€',  'exchange_rate' => 0.90],
            ['name' => 'Argentine Peso','symbol' => '$', 'exchange_rate' => 875.00],
            ['name' => 'British Pound','symbol' => '£',  'exchange_rate' => 0.78],
            ['name' => 'Japanese Yen', 'symbol' => '¥',  'exchange_rate' => 155.20],
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['name' => $currency['name']],
                $currency
            );
        }
    }
}
