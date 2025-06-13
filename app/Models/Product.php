<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'currency_id',
        'tax_cost',
        'manufacturing_cost',
    ];

    protected $casts = [
        'price' => 'float',
        'tax_cost' => 'float',
        'manufacturing_cost' => 'float',
    ];

    public function currency() : BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
