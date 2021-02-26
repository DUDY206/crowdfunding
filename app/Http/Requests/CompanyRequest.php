<?php

namespace App\Http\Requests;

use App\Helper;
use App\Models\Company;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CompanyRequest extends TraitRequest
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
        $name_id = null;
        $existed_name_vi = Language::where('field','companies.name')->whereVi($this->request->get('name_vi'));
        $existed_name_en = Language::where('field','companies.name')->whereEn($this->request->get('name_en'));
        $errors = []; //store message check unique name
        if($this->method() === 'PUT'){
            //edit company
            $name_id = Company::findOrFail($this->route('company'))->name;
            $existed_name_vi = $existed_name_vi->where('id','<>',$name_id);
            $existed_name_en = $existed_name_en->where('id','<>',$name_id);
        }
        if(count($existed_name_vi->get()) != 0){
            $errors['name_vi'] = [__('message-request.company.name_vi.unique')];
        }
        if(count($existed_name_en->get()) != 0){
            $errors['name_en'] = [__('message-request.company.name_en.unique')];
        }
        if($errors != []){
            throw new HttpResponseException(
                response()->json(['errors' => $errors],JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
        $rules = [
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'name_vi' => 'required',
            'name_en' => 'required'
        ];

        $usecase = explode('/',$_SERVER['REQUEST_URI'])[1];
        if($usecase == 'admin'){
            //admin manual add id
            $rules['account_id'] = 'required';
        }else{
            //server auto check user id
            $this->request->add([
                'account_id' => $this->user('api')->id
            ]);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'img_url.image' => __('message-request.company.img_url.image'),
            'img_url.mimes' => __('message-request.company.img_url.mimes'),
            'name_vi.required' => __('message-request.company.name_vi.required'),
            'name_vi.unique' => __('message-request.company.name_vi.unique'),
            'name_en.required' => __('message-request.company.name_en.required'),
            'name_en.unique' => __('message-request.company.name_en.unique'),
            'account_id.required' => __('message-request.company.account_id.required'),
        ];
    }
}
