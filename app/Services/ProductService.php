<?php 

namespace App\Services;

use App\DTOs\Product\CreateProductDTO;
use App\DTOs\Product\UpdateProductDTO;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService {

    protected $relations = ['currency'];

    public function getAllProducts() : Collection
    {
        try {

            return Product::with([
                'currency'
            ])->get();

        } catch(\Exception $e) {

            throw new \RuntimeException($e->getMessage());

        }
    }

    public function createProduct(CreateProductDTO $dto) : Product
    {
        try {

            $product = Product::create($dto->toArray());

            $product->load($this->relations);

            return $product;

        } catch(\Exception $e) {

            throw new \RuntimeException($e->getMessage());

        } 
    }

    public function updateProduct(Product $product, UpdateProductDTO $dto) : Product
    {
        try {

            $product->update($dto->toUpdateArray());

            $product->load($this->relations);

            return $product;

        } catch(\Exception $e) {

            throw new \RuntimeException($e->getMessage());

        }
    }

    public function deleteProduct(Product $product) : void
    {
        try {

            $product->delete();

        } catch(\Exception $e) {

            throw new \RuntimeException($e->getMessage());

        }
    }

}

?>