<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSeed extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'nameOfSeed' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'integer', 'exists:seed_types,idSeedType'],
        ];
    }
}
