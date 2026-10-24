<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTree extends FormRequest
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
            'idSeed' => ['required', 'integer', 'exists:seeds,idSeed'],
            'idOwner' => ['required', 'integer', 'exists:users,id'],
            'level' => ['required', 'integer', 'min:1'],
            'health' => ['required', 'integer', 'max:100'],
            'progress' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'max:255', 'in:alive,dead'],
           
           
        ];
    }
}
