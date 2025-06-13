<?php 

namespace App\DTOs\Product;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;

class CreateProductDTO extends Data
{
    public function __construct(

        public string $name,
        public string $description,
        public float $price,

        #[IntegerType, Exists('currencies', 'id')]
        public int $currency_id,

        public float $tax_cost,
        public float $manufacturing_cost,

    ){}
}