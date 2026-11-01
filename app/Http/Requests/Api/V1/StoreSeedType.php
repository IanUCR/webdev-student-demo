<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSeedType extends FormRequest
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
            'typeOfSeed' => ['required', 'string', 'max:255','in:normal,special'],
            'care_per_level' => ['required', 'integer', 'min:1'],
            'haervest_reward_in_coins' => ['required', 'integer', 'min:1'],

        ];
    }
}
