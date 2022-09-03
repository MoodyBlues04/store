<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:20'],
            'price' => ['nullable', 'int'],
            'amount' => ['nullable', 'int'],
            'image' => ['nullable', 'image'],
            'description' => ['string', 'max:500', 'nullable'],
            'characteristics' => ['string', 'max:500', 'nullable'],
            'photos' => 'nullable',
            'photos.*' => 'mimes:jpg,jpeg,png',
        ];
    }
}
