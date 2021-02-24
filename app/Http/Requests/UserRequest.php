<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends TraitRequest
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
        $required = [
            'password' => 'required'
        ];
        if($this->method() === 'PUT'){
            $id = $this->route('user_info');
            $required['password'] = 'nullable';
        }

        return [
            'user_name' => 'required|unique:account,user_name,'.$id,
            'full_name' => 'required',
            'password'  => $required['password'].'|min:8',
            'email' => 'required|email|unique:account,email,'.$id,
            'phone_number' => 'required|unique:account,phone_number,'.$id,
            'date_of_birth' => 'required|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable',
            'slogan' => 'nullable',
            'is_verify' => 'nullable|boolean',
            'is_reliable_investor' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return  [
            "user_name.required" => __("message-request.user-info.user_name.required"),
            "user_name.unique" => __("message-request.user-info.user_name.unique"),
            "full_name.required" => __("message-request.user-info.full_name.required"),
            "password.required" => __("message-request.user-info.password.required"),
            "password.min" => __("message-request.user-info.password.min"),
            "email.required" => __("message-request.user-info.email.required"),
            "email.email" => __("message-request.user-info.email.email"),
            "email.unique" => __("message-request.user-info.email.unique"),
            "phone_number.required" => __("message-request.user-info.phone_number.required"),
            "phone_number.unique" => __("message-request.user-info.phone_number.unique"),
            'date_of_birth.required' => __("message-request.user-info.date_of_birth.required"),
            "date_of_birth.date" => __("message-request.user-info.date_of_birth.date"),
            "avatar.image" => __("message-request.user-info.avatar.image"),
            "avatar.mimes" => __("message-request.user-info.avatar.mimes"),
            "cover_photo.image" => __("message-request.user-info.cover_photo.image"),
            "cover_photo.mimes" => __("message-request.user-info.cover_photo.mimes"),
            "is_verify.boolean" => __("message-request.user-info.is_verify.boolean"),
            "is_reliable_investor.boolean" => __("message-request.user-info.is_reliable_investor.boolean"),
        ];

    }
}
