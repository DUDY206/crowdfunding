<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends TraitRequest
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
            $img_url = 'nullable';
        } else {
            $img_url = 'required|image|mimes:jpeg,png,jpg,gif';
        }

        return [
            'invest_id' => 'required',
            'name_vi' => 'required',
            'name_en' => 'required',
            'description_vi' => 'nullable',
            'description_en' => 'nullable',
            'img_url' => $img_url,
            'content_vi' => 'required',
            'content_en' => 'required',
        ];
    }

    public function messages()
    {
        return  [
            "invest_id.required"        =>  "Chưa nhập ID dự án",
            "name_vi.required"          =>  "Chưa nhập tên tin tức",
            "name_en.required"          =>  "Chưa nhập tên tin tức",
            "img_url.required"          =>  "Chưa chọn ảnh đại diện",
            "img_url.image"             =>  "Ảnh không hợp lệ",
            "img_url.mimes"             =>  "Ảnh không hợp lệ",
            "content_vi.required"       =>  "Chưa nhập nội dung tin tức",
            "content_en.required"       =>  "Chưa nhập nội dung tin tức",
        ];
    }
}
