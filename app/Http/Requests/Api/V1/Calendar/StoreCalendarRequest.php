<?php

namespace App\Http\Requests\Api\V1\Calendar;

use App\Models\Connector;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCalendarRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'         => [
                'required',
                'string',
                Rule::unique('calendars', 'name')->where('user_id', $this->user()->id),
            ],
            'connectors'   => [
                'array',
                'nullable',
            ],
            'connectors.*' => [
                Rule::in($this->user()->connectors()->pluck('id')->toArray()),
            ],
        ];
    }
}
