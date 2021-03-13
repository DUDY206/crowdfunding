<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestHasContractFieldValueRequest extends FormRequest
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
            'contract_value' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'invest_id.required' => 'Invest ID required',
            'invest_id.exists' => 'Invest ID not exists',
            'contract_value.required' => 'Contract value required',
        ];
    }
}
