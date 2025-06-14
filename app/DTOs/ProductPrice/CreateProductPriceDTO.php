<?php 

namespace App\DTOs\ProductPrice;

use App\Models\Currency;
use App\Models\Product;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;

class CreateProductPriceDTO extends Data
{
    public function __construct(

        #[IntegerType, Exists('products', 'id')]
        public int $product_id,

        #[IntegerType, Exists('currencies', 'id')]
        public int $currency_id

    ){}
}

?>