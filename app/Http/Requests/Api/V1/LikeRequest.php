<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Controllers\Api\V1\LikeController;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LikeRequest extends FormRequest
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
            'entity' => [
                'required',
                'string',
                Rule::in(array_keys(LikeController::$entities))
            ],
            'id'     => [
                'required',
            ],
        ];
    }

    public function getModel(): Model
    {
        /** @var Model $model */
        $model = LikeController::$entities[$this->get('entity')];

        return $model::findOrFail($this->get('id'));
    }
}
