<?php

namespace App\Http\Requests;

use App\Models\CompanyInvest;
use Illuminate\Foundation\Http\FormRequest;

class FAQRiskRequest extends TraitRequest
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
            'is_faq' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
              'invest_id.required' => __('message-request.company-invest.faq_risk.invest_id.required'),
              'invest_id.exists' => __('message-request.company-invest.faq_risk.invest_id.exists'),
              'is_faq.required' => __('message-request.company-invest.faq_risk.is_faq'),
              'is_faq.boolean' => __('message-request.company-invest.faq_risk.is_faq'),
        ];
    }
}
