<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{

    use RefreshDatabase;

    protected $currency;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currency = Currency::factory()->create();
    }

    public function test_can_list_products()
    {
        Product::factory()->count(3)->create(['currency_id' => $this->currency->id]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'ok',
                'products' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'currency_id',
                        'tax_cost',
                        'manufacturing_cost',
                        'created_at',
                        'updated_at',
                        'currency' => [
                            'id',
                            'name',
                            'symbol',
                            'exchange_rate',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ]
            ]);
    }

    public function test_can_show_single_product()
    {
        $product = Product::factory()->create(['currency_id' => $this->currency->id]);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $product->name]);
    }

    public function test_can_create_product()
    {
        $data = [
            'name' => 'Test Product',
            'description' => 'Description here',
            'price' => "99.99",
            'currency_id' => $this->currency->id,
            'tax_cost' => "10.00",
            'manufacturing_cost' => "20.00",
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Test Product']);

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create(['currency_id' => $this->currency->id]);

        $data = [
            'name' => 'Updated Name',
        ];

        $response = $this->putJson("/api/products/{$product->id}", $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Name']);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create(['currency_id' => $this->currency->id]);

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

}
