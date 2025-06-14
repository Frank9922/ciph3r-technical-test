<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductPriceRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\ApiResponse;
use App\Services\ProductPriceService;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private ProductPriceService $productPriceService
    ) {}

    public function index() : JsonResponse 
    {
        try {
            
            $products = $this->productService->getAllProducts();

            return ApiResponse::success(['products' => $products]);

        } catch(\RuntimeException $e) {
            
            return ApiResponse::error($e->getMessage());
        }
    }

    public function store(StoreProductRequest $request) : JsonResponse 
    {
        try {

            $newProduct = $this->productService->createProduct($request->toCreateProductDTO());

            return ApiResponse::success(['newProduct' => $newProduct], 'Product created successfully');

        } catch(\RuntimeException $e) {

            return ApiResponse::error($e->getMessage());
        }
    }

    public function show(Product $product) : JsonResponse 
    {
        try {

            return ApiResponse::success(['product' => $product->load([
                'currency'
            ])]);

        } catch(\RuntimeException $e) {

            return ApiResponse::error($e->getMessage());

        }
    }

    public function update(UpdateProductRequest $request, Product $product) : JsonResponse 
    {
        try {

            $updateProduct = $this->productService->updateProduct($product, $request->toUpdateProductDTO());

            return ApiResponse::success(['product' => $updateProduct], 'Product updated successfully');

        } catch(\RuntimeException $e) {

            return ApiResponse::error($e->getMessage());

        }
    }

    public function destroy(Product $product) : JsonResponse 
    {
        try {

            $product->delete();

            return ApiResponse::success([], 'Product deleted successfully');

        } catch(\RuntimeException $e) {

            return ApiResponse::error($e->getMessage());

        }
    }

    public function prices(Product $product) : JsonResponse 
    {
        try {

            return ApiResponse::success([
                'prices' => $this->productPriceService->getPricesByProduct($product)
            ]);

        } catch(\RuntimeException $e) {

            return ApiResponse::error($e->getMessage());

        }
    }

    public function storePrice(StoreProductPriceRequest $request, Product $product) : JsonResponse 
    {
        try {

            $newProductPrice = $this->productPriceService->createProductPrice($request->toCreateProductPriceDTO());

            return ApiResponse::success(['newProductPrice' => $newProductPrice], 'Product price created successfully');

        } catch(\RuntimeException $e) {

            return ApiResponse::error($e->getMessage());

        }
    }

}
