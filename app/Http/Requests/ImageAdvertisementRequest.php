<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageAdvertisementRequest extends TraitRequest
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
            $img = 'nullable';
        } else {
            $img = 'required|image|mimes:jpeg,png,jpg,gif';
        }

        return [
            'img' => $img,
        ];
    }

    public function messages()
    {
        return  [
            "img.required"             =>  "Chưa chọn ảnh",
            "img.image"                =>  "Ảnh không hợp lệ",
            "img.mimes"                =>  "Ảnh không hợp lệ",
        ];
    }
}
