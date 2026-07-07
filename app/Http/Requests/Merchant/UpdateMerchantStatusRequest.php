<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchantStatusRequest extends FormRequest
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
                    'status' => 'required|in:approved,rejected',
                    'remarks' => 'nullable|string',
                ];
            }
}
