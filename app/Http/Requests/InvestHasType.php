<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestHasType extends TraitRequest
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
            'invest_type' => 'array'
        ];
    }

    public function messages()
    {
        return [
            'invest_id.required' => 'Chưa có id dự án',
            'invest_id.exists' => 'Dự án không tồn tại',
            'invest_type.array' => 'Danh sách loại hợp đồng không hợp lệ',
        ];
    }
}
