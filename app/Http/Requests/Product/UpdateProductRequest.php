<?php

namespace App\Http\Requests\Product;

use App\DTOs\Product\UpdateProductDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        return [
            'name' => 'string|sometimes',
            'description' => 'string|sometimes',
            'price' => 'numeric|sometimes',
            'currency_id' => 'exists:currencies,id|sometimes',
            'tax_cost' => 'numeric|sometimes',
            'manufacturing_cost' => 'numeric|sometimes',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (empty($this->only([
                'name',
                'description',
                'price',
                'currency_id',
                'tax_cost',
                'manufacturing_cost'
            ]))) {
                $validator->errors()->add('update', 'You must provide at least one field to update.');
            }
        });
    }
    


    public function toUpdateProductDTO() : UpdateProductDTO
    {
        return UpdateProductDTO::from($this->validated());
    }
}
