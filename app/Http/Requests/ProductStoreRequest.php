<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getImage(): UploadedFile
    {
        return $this->image;
    }

    /**
     * @return array<int,UploadedFile>
     */
    public function getPhotos()
    {
        return $this->photos;
    }
    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'price' => ['required', 'int'],
            'amount' => ['required', 'int'],
            'image' => ['required', 'image'],
            'description' => ['string', 'max:500', 'nullable'],
            'characteristics' => ['string', 'max:500', 'nullable'],
            'photos' => 'required',
            'photos.*' => 'mimes:jpg,jpeg,png',
        ];
    }
}
