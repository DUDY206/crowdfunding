<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\CompanyInvest;
use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CompanyInvestRequest extends TraitRequest
{
    public $companyInvest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $usecase = explode('/',$_SERVER['REQUEST_URI'])[1];
        if($usecase === 'admin'){
            return true;
        }else{
            if($this->method() === 'PUT'){
                $this->companyInvest =  CompanyInvest::findOrFail($this->route('company_invest'));
                if($this->companyInvest->company->onwer->id === $this->user('api')->id){
                    return true;
                }
            }else{
                $company = Company::findOrFail($this->get('company_id'));
                if($company->owner->id === $this->user('api')->id){
                    return true;
                }
            }
        }


        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $errors = []; //store message check unique name
        $existed_name_vi = Language::where('field','company-invest.name')->whereVi($this->request->get('name_vi'));
        $existed_name_en = Language::where('field','company-invest.name')->whereEn($this->request->get('name_en'));
        if($this->method() === 'PUT'){
            //edit company
            $name_id = CompanyInvest::findOrFail($this->route('company_invest'))->name;
            $existed_name_vi = $existed_name_vi->where('id','<>',$name_id);
            $existed_name_en = $existed_name_en->where('id','<>',$name_id);
        }
        if(count($existed_name_vi->get()) != 0){
            $errors['name_vi'] = [__('message-request.company-invest.name_vi.unique')];
        }
        if(count($existed_name_en->get()) != 0){
            $errors['name_en'] = [__('message-request.company-invest.name_en.unique')];
        }
        if($errors != []){
            throw new HttpResponseException(
                response()->json(['errors' => $errors],JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
        return [
            'name_vi' => 'required',
            'name_en' => 'required',
            'short_description_vi' => 'nullable',
            'short_description_en' => 'nullable',
            'img_url'=>'nullable|image|mimes:jpeg,png,jpg,gif',
            'video_url'=>'nullable',
            'min_invest'=>'required|numeric|min:0',
            'valuation_cap'=>'required|numeric|min:0',
            'location_vi'=>'nullable',
            'location_en'=>'nullable',
            'status'=>'required|numeric',
            'company_id'=>'required|exists:companies,id',
            'total_follow'=>'nullable|numeric|min:0',
            'mutable_field.*.position' => 'nullable|numeric|min:0'
            //
        ];
    }

    public function messages()
    {
        return  [
            "name_vi.required"          =>  __('message-request.company-invest.name_vi.required'),
            "name_en.required"          =>  __('message-request.company-invest.name_en.required'),
            "min_invest.required"       =>  __('message-request.company-invest.min_invest.required'),
            "min_invest.numeric"        =>  __('message-request.company-invest.min_invest.numeric'),
            "min_invest.min"            =>  __('message-request.company-invest.min_invest.min'),
            "valuation_cap.required"    =>  __('message-request.company-invest.valuation_cap.required'),
            "valuation_cap.numeric"     =>  __('message-request.company-invest.valuation_cap.numeric'),
            "valuation_cap.min"         =>  __('message-request.company-invest.valuation_cap.min'),
            "status.required"           =>  __('message-request.company-invest.status.required'),
            "status.numeric"            =>  __('message-request.company-invest.status.numeric'),
            "company_id.required"       =>  __('message-request.company-invest.company_id.required'),
            "company_id.exists"         =>  __('message-request.company-invest.company_id.exists'),
            "total_follow.numeric"      =>  __('message-request.company-invest.total_follow.numeric'),
            "total_follow.min"          =>  __('message-request.company-invest.total_follow.min'),
            "img_url.image"             =>  __('message-request.company.img_url.image'),
            "img_url.mimes"             =>  __('message-request.company.img_url.mimes'),
            'mutable_field.*.position.numeric'   => __('message-request.company-invest.mutable_field.position'),
        ];
    }
}
