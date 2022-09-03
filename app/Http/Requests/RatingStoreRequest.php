<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RatingStoreRequest extends FormRequest
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
            'user' => 'required',
            'value' => ['required', 'int']
        ];
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getUserModel(): User
    {
        return User::findOrFail($this->user);
    }
}
