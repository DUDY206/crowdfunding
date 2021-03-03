<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestTypeRequest extends TraitRequest
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
            'name_vi' => 'required',
            'name_en' => 'required',
            'short_description_vi' => 'required',
            'short_description_en' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_vi.required' => 'Chưa nhập tên hình thức đầu tư tiếng Việt',
            'name_en.required' => 'Chưa nhập tên tiếng Anh',
            'short_description_vi.required' => 'Chưa nhập mô tả tiếng Việt',
            'short_description_en.required' => 'Chưa nhập mô tả tiếng Anh',
        ];
    }
}
