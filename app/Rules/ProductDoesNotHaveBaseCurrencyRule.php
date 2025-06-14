<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductDoesNotHaveBaseCurrencyRule implements ValidationRule
{
    protected int $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::findOrFail($this->productId);

        if($product->currency_id === $value) $fail('The currency must be different from the product base currency');
    }
}
