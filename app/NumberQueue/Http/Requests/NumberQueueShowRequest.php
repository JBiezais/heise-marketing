<?php

namespace App\NumberQueue\Http\Requests;

use App\NumberQueue\Actions\ConvertNextNumber\Enums\NumberQueueLocale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NumberQueueShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string|Rule>>
     */
    public function rules(): array
    {
        return [
            'locale' => ['sometimes', 'string', Rule::enum(NumberQueueLocale::class)],
        ];
    }
}
