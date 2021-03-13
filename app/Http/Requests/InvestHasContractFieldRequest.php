<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestHasContractFieldRequest extends FormRequest
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
            'invest_contract_field_id' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'invest_id.required'=>'Invest Id required',
            'invest_id.exists'=>'Invest ID không tồn tại',
            'invest_contract_field_id.required'=>'Invest contract field required',
            'invest_contract_field_id.exists'=>'Invest contract field hợp lệ',
        ];
    }
}
