<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterPaticipate extends TraitRequest
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
            'fullname' => 'required|min:5',
            'email' => 'required|min:5|email',
            'phone' => 'required|regex:/(0)[0-9]{9}/|max:11',
            'date_of_birth' => 'required|date',
            'position' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'fullname.required'         => 'fullname.required',
            'fullname.min'              => 'fullname.min',
            'email.required'            => 'email.required',
            'email.min'                 => 'email.min',
            'email.email'               => 'email.email',
            'phone.required'            => 'phone.required',
            'phone.regex'               => 'phone.regex',
            'phone.max'                 => 'phone.max',
            'date_of_birth.required'    => 'date_of_birth.required',
            'date_of_birth.date'        => 'date_of_birth.date',
            'position.required'         => 'position.required',
            'position.numeric'          => 'position.numeric',
        ];
    }
}
