<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPriceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_product_prices()
    {
        $currency1 = Currency::factory()->create();
        $currency2 = Currency::factory()->create();

        $product = Product::factory()->create(['currency_id' => $currency1->id]);

        ProductPrice::factory()->create([
            'product_id' => $product->id,
            'currency_id' => $currency1->id,
            'price' => 50.00,
        ]);

        ProductPrice::factory()->create([
            'product_id' => $product->id,
            'currency_id' => $currency2->id,
            'price' => 60.00,
        ]);

        $response = $this->getJson("/api/products/{$product->id}/prices");

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'prices');
    }

    public function test_can_store_product_price()
    {
        $baseCurrency = Currency::factory()->create(['exchange_rate' => 1.0]);
        $targetCurrency = Currency::factory()->create(['exchange_rate' => 0.85]);

        $product = Product::factory()->create([
            'currency_id' => $baseCurrency->id,
            'price' => 100.00,
        ]);

        $payload = [
            'product_id' => $product->id,
            'currency_id' => $targetCurrency->id,
        ];

        $response = $this->postJson("/api/products/{$product->id}/prices", $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'ok',
                'newProductPrice' => [
                        'id',
                        'product_id',
                        'currency_id',
                        'price',
                    ],
                'message',
            ]);

        $expectedPrice = round($product->price * ($targetCurrency->exchange_rate / $baseCurrency->exchange_rate), 2);

        $this->assertDatabaseHas('product_prices', [
            'product_id' => $product->id,
            'currency_id' => $targetCurrency->id,
            'price' => $expectedPrice,
        ]);
    }
}
