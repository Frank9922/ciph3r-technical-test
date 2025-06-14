<?php 

namespace App\Services;

use App\DTOs\ProductPrice\CreateProductPriceDTO;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Support\Collection;

class ProductPriceService {

    private array $relations = ['currency', 'product', 'product.currency'];

    public function getPricesByProduct(Product $product) : Collection
    {
        try {

            return $product->prices()->with($this->relations)->get();

        } catch(\Exception $e) {
        
            throw new \RuntimeException($e->getMessage());
        
        }

    }

    public function createProductPrice(CreateProductPriceDTO $dto) : ProductPrice
    {
        try {

            $product = Product::with('currency')->findOrFail($dto->product_id);

            $targetCurrency = Currency::findOrFail($dto->currency_id);

            $convertedPrice = $this->calculateConvertedPrice($product, $targetCurrency);

            $newProductPrice = ProductPrice::create([
                'product_id' => $dto->product_id,
                'currency_id' => $dto->currency_id,
                'price' => $convertedPrice,
            ]);

            return $newProductPrice->load($this->relations);

        } catch(\Exception $e) {

            throw new \RuntimeException($e->getMessage());

        }
    }

    private function calculateConvertedPrice(Product $product, Currency $targetCurrency) : float
    {
        $baseCurrency = $product->currency;

        return round($product->price * ($targetCurrency->exchange_rate / $baseCurrency->exchange_rate),
        2
    );
    }


}

?>