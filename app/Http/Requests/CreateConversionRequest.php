<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConversionRequest extends FormRequest
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
            'from_currency' => 'required|in:EUR,USD,GEL',
            'to_currency' => 'required|in:EUR,USD,GEL',
            'from_amount' => 'required|numeric',
            'to_amount' => 'nullable|numeric',
        ];
    }
}
