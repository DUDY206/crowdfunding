<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractTemplateRequest extends TraitRequest
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
            'name'=>'required',
            'template' => 'required',
            'input_label' => 'required|regex:/([0-9]+:"([a-zA-z]*\s*)*"(,)*)*/',
            'invest_type_id' => 'required|exists:invest_types,id'
        ];
    }

    public function messages()
    {
        return  [
            "name.required" => "Chưa nhập tên hợp đồng",
            "template.required" => "Chưa nhập nội dung hợp đồng",
            "input_label.required" => "Input_label không hợp lệ",
            "input_label.regex" => "Input_label không hợp lệ",
            "invest_type_id.required" => "Loại hợp đồng không hợp lệ",
            "invest_type_id.exists" => "Loại hợp đồng không hợp lệ",
        ];
    }
}
