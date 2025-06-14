<?php

namespace App\Http\Requests\Product;

use App\DTOs\ProductPrice\CreateProductPriceDTO;
use App\Rules\ProductDoesNotHaveBaseCurrencyRule;
use App\Rules\UniqueProductCurrencyCombinationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'currency_id' => [
                'required',
                'exists:currencies,id',
                new ProductDoesNotHaveBaseCurrencyRule($product->id),
                new UniqueProductCurrencyCombinationRule($product->id)
            ],
        ];
    }

    public function toCreateProductPriceDTO() : CreateProductPriceDTO
    {
        return CreateProductPriceDTO::from([
            'product_id' => $this->route('product')->id,
            'currency_id' => $this->validated('currency_id'),
        ]);
    }
}
