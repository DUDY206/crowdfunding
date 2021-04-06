<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class RegAdminRequest extends TraitRequest
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
        $id = null;
        $password = '';

        if ($this->method() === 'PUT') {
            $id = $this->route('manage_admin');
            $password = '';
        } else {
            $password = 'required|min:8';
        }

        return [
            'user_name' => 'required|unique:admins,user_name,'.$id,
            'full_name' => 'required',
            'password'  => $password,
            'email' => 'required|email|unique:admins,email,'.$id,
            'phone_number' => 'required|unique:admins,phone_number,'.$id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];
    }

    public function messages()
    {
        return [
            //admin quản lí -> để tiếng Việt
            'user_name.required'  => 'Chưa nhập user name',
            'user_name.unique'  => 'Username đã tồn tại',
            'full_name.required'  => 'Chưa nhập họ tên',
            'password.required'  => 'Chưa nhập mật khẩu',
            'password.min'  => 'Mật khẩu quá ngắn',
            'email.required'  => 'Chưa nhập email',
            'email.email'  => 'Email không hợp lệ',
            'email.unique'  => 'Email đã tồn tại',
            'phone_number.required'  => 'Chưa nhập số điện thoại',
            'phone_number.unique'  => 'Số điện thoại đã tồn tại',
            'avatar.image'  => 'Ảnh đại diện không hợp lệ',
        ];
    }
}
