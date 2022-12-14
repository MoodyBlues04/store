<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'username' => ['nullable', 'string', 'max:20'],
            'introduction' => ['nullable', 'string', 'max:500'],
            'image' => ['image', 'mimes:jpg,jpeg,png', 'nullable']
        ];
    }
}
