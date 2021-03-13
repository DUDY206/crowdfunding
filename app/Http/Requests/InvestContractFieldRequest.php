<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestContractFieldRequest extends TraitRequest
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
            'field_vi' => 'required',
            'field_en' => 'required',
        ];
    }

    public function messages()
    {
        return [
            "field_vi.required" => "Chưa nhập tên trường tiếng Việt",
            "field_en.required" => "Chưa nhập tên trường tiếng Anh",
        ];
    }
}
