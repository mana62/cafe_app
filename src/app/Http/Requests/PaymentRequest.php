<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method' => 'required|string|in:クレジットカード,コンビニ払い',
            'payment_intent_id' => 'nullable|string',
            'selected_items' => 'required|array',
            'selected_items.*' => 'required|integer',
        ];
    }
}
