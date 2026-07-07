<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TransferMoneyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        'receiver_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
    ];
}
}
