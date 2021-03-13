<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractInputFieldRequest extends TraitRequest
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
            'field_vi.required' => 'Tên trường nhập tiếng Việt không được để trống',
            'field_en.required' => 'Tên trường nhập tiếng Anh không được để trống',
        ];
    }
}
