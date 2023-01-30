<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
            'transaction_date' => ['required', 'date_format:Y-m-d H:i:s'],
            'total' => ['required', 'integer'],
            'detail.*.bank_id' => ['required', 'integer'],
            'detail.*.account_number' => ['required', 'string', 'min:10'],
            'detail.*.admin_banks_bank_id' => ['required', 'integer'],
            'detail.*.admin_banks_account_number' => ['required', 'string', 'min:10'],
            'detail.*.amount' => ['required', 'integer'],
        ];
    }
}
