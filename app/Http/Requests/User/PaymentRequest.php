<?php

namespace App\Http\Requests\User;

use App\Traits\UserValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    use UserValidationTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id'
        ];
    }
}
