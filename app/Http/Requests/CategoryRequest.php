<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends TraitRequest
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
        if ($this->method() === 'PUT') {
            $logo = 'nullable';
        } else {
            $logo = 'required|image|mimes:jpeg,png,jpg,gif';
        }

        return [
            'logo' => $logo,
            'img_cover' => 'nullable',
            'name_vi' => 'required',
            'name_en' => 'required',
            'description_vi' => 'nullable',
            'description_en' => 'nullable',
        ];
    }

    public function messages()
    {
        return  [
            "logo.required"             =>  "Chưa chọn logo",
            "logo.image"                =>  "Logo không hợp lệ",
            "logo.mimes"                =>  "Logo không hợp lệ",
            "img_cover.image"           =>  "Ảnh cover không hợp lệ",
            "img_cover.mimes"           =>  "Ảnh cover không hợp lệ",
            "name_vi.required"          =>  "Chưa nhập tên tin tức",
            "name_en.required"          =>  "Chưa nhập tên tin tức",
            "content_vi.required"       =>  "Chưa nhập nội dung tin tức",
            "content_en.required"       =>  "Chưa nhập nội dung tin tức",
        ];
    }
}
