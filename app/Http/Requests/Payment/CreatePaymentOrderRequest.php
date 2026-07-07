<?php

namespace App\Http\Requests\Payment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentOrderRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                   'amount' => 'required|numeric|min:1',
        'currency' => 'nullable|string|size:3',
        'customer_name' => 'nullable|string|max:255',
        'customer_email' => 'nullable|email',
        'customer_phone' => 'nullable|string|max:20',
        'callback_url' => 'nullable|url',
        'metadata' => 'nullable|array',
        ];
    }
}
