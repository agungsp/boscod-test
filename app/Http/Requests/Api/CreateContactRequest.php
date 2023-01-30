<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bank_id' => ['required', 'integer'],
            'account_number' => ['required', 'string', 'min:10'],
            'name' => ['required', 'string', 'max:100'],
            'label' => ['nullable', 'string', 'max:100'],
            'is_favorite' => ['nullable', 'boolean']
        ];
    }
}
