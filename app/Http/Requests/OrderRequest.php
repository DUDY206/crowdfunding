<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends TraitRequest
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
            'invest_id' => 'required|exists:company_investments,id',
            'invest_type_id' => 'required|exists:invest_types,id',
            'contract_value' => 'required',
            'amount' => 'required|numeric',
            'payment_status' => 'required|numeric',
            'send_mail' => 'nullable|email:rfc,dns'
        ];
    }

    public function messages()
    {
        return [
            'invest_id.required' => 'Invest ID required',
            'invest_id.exists' => 'Invest ID not exist',
            'invest_type_id.required' => 'invest_type_id required',
            'invest_type_id.exists' => 'invest_type_id not exist',
            'amount.required' => 'Số tiền required',
            'amount.numeric' => 'Số tiền không hợp lệ',
            'payment_status.required' => 'Trạng thái thanh toán required',
            'payment_status.numeric' => 'Trạng thái thanh toán không hợp lệ',
            'is_signature.boolean' => 'Xác nhận ký không hợp lệ',
            'send_mail.email' => 'Email',

        ];
    }
}
