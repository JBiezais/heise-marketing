<?php

namespace App\NumberQueue\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NumberQueueStoreRequest extends FormRequest
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
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'integer', 'min:0'],
        ];
    }
}
