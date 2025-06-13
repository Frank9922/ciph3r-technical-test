<?php 

namespace App\DTOs\Product;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;

class UpdateProductDTO extends Data
{
    public function __construct(

        public ?string $name,
        public ?string $description,
        public ?float $price,

        #[IntegerType, Exists('currencies', 'id')]
        public ?int $currency_id,

        public ?float $tax_cost,
        public ?float $manufacturing_cost,

    ){
        if(empty(array_filter(get_object_vars($this)))) {
            throw new \InvalidArgumentException('Al menos un campo debe ser proporcionado para actualizar.');
        }
    }

    public function toUpdateArray() : array
    {
        return array_filter($this->toArray(), function ($value) {
            return $value !== null && $value !== '';
        });
    }
}