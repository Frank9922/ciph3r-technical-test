<?php

namespace App\Rules;

use App\Models\ProductPrice;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueProductCurrencyCombinationRule implements ValidationRule
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
        $exists = ProductPrice::where('product_id', $this->productId)
                ->where('currency_id', $value)
                ->exists();

        if($exists) $fail('This product already has a price registered in the selected currency.');
    }
}
