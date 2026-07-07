<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateMerchantRequest extends FormRequest
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
                    'business_name' => 'required|string|max:255',
                    'business_email' => 'nullable|email',
                    'business_phone' => 'nullable|string|max:20',
                    'business_type' => 'nullable|string|max:100',
                ];
            }
}
