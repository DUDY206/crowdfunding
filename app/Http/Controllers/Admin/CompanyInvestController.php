<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInvestRequest;
use App\Models\Company;
use App\Models\CompanyInvest;
use App\Models\InvestImmutableField;
use App\Models\InvestMutableField;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;

class CompanyInvestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
            CompanyInvest::paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompanyInvestRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validated();
            $lang_short_description = [];
            $lang_location = [];

            $lang_name = Helper::createLanguage($request,'name_vi','name_en','company-invest.name');

            $lang = Helper::createLanguage($request,'short_description_vi','short_description_en','company-invest.short_description');
            if($lang != null) $lang_short_description = ['short_description' => $lang->id];

            $lang = Helper::createLanguage($request,'location_vi','location_en','company-invest.location');
            if($lang != null) $lang_location = ['location' => $lang->id];

            $company_invest = CompanyInvest::create(
                $request->except(['name_vi','name_en','short_description_vi','short_description_en','location_vi','location_en','img_url'])+[
                    'name' => $lang_name->id,
                    'img_url' => Helper::saveImage(null,$request->file('img_url'),'companyInvest/img')
                ]+
                $lang_short_description+
                $lang_location
            );

            //IMMUTABLE FIELD
            $list_immutable_fields_request = $request->get('immutable_field');
            $lang_immutable_field = [];
            if($list_immutable_fields_request !== null){
                $lang_immutable_field =  Helper::createLanguageForArrayField($list_immutable_fields_request,InvestImmutableField::getLangArray());
            }
            if(count($lang_immutable_field) != 0){
                InvestImmutableField::create([
                    'invest_id' => $company_invest->id
                ]+$lang_immutable_field);
            }

            //MUTABLE FIELD
            $const_lang_mutable_field = InvestMutableField::getLangArray();
            $list_mutable_fields_input =  $request->get('mutable_field') ?? [];
            foreach ($list_mutable_fields_input as $mutable_field){
                $lang_mutable_field = Helper::createLanguageForArrayField($mutable_field,$const_lang_mutable_field);
                InvestMutableField::create([
                    'invest_id' => $company_invest->id,
                    'position' => $mutable_field['position']
                ]+$lang_mutable_field);
            }

            DB::commit();
            return response()->json($company_invest->fresh());
        }catch (Exception $exception){
            DB::rollBack();
            return response()->json([
                'error' => $exception
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $companyInvest = CompanyInvest::findOrFail($id);
            return response()->json($companyInvest);
        }catch (Exception $exception){
            return  response()->json([
                'error' => 'Not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CompanyInvestRequest $request, $id)
    {
        DB::beginTransaction();
        $company_invest = CompanyInvest::findOrFail($id);
        try {
            $request->validated();
            $lang_short_description = [];
            $lang_location = [];
            $img_url = [];

            $lang_name = $company_invest->lang_name;
            $lang_name->update([
                'vi' => $request->get('name_vi'),
                'en' => $request->get('name_en'),
            ]);

            $lang = Helper::updateLanguage($request,$company_invest,'short_description','short_description_vi','short_description_en','company-invest.short_description');
            if($lang != null) $lang_short_description = ['short_description' => $lang->id];

            $lang = Helper::updateLanguage($request,$company_invest,'location','location_vi','location_en','company-invest.location');
            if($lang != null) $lang_location = ['location' => $lang->id];

            if($request->hasFile('img_url')){
                $img_url = ['img_url' => Helper::saveImage(null,$request->file('img_url'),'companyInvest/img')];
            }

            $company_invest->update(
                $request->except(['name_vi','name_en','short_description_vi','short_description_en','location_vi','location_en','img_url'])+
                $img_url+
                $lang_short_description+
                $lang_location
            );

            //IMMUTABLE FIELD
            $list_immutable_fields_request = $request->get('immutable_field');
            $lang_immutable_field = [];
            $company_immutable_field = $company_invest->fresh()->immutable_field;
            if($list_immutable_fields_request !== null)
                if($company_immutable_field !== null){
                    //edit
                    foreach (InvestImmutableField::getLangArray() as $field){
                        $lang_field  = Helper::updateLanguageByArrayRequestItem($request->get('immutable_field'),$company_immutable_field,$field,$field.'_vi',$field.'_en','company-invest.immutable_field.'.$field);
                    }
                }else{
                    //create
                    $lang_immutable_field =  Helper::createLanguageForArrayField($list_immutable_fields_request,InvestImmutableField::getLangArray());
                    if(count($lang_immutable_field) != 0){
                        InvestImmutableField::create([
                                'invest_id' => $company_invest->id
                            ]+$lang_immutable_field);
                    }
                }




            //MUTABLE FIELD
            $invest_mutable_field = $company_invest->fresh()->mutable_field;
            foreach ($invest_mutable_field as $field){
                $field->delete();
            }

            $const_lang_mutable_field = InvestMutableField::getLangArray();
            $list_mutable_fields_input =  $request->get('mutable_field') ?? [];
            foreach ($list_mutable_fields_input as $mutable_field){
                $lang_mutable_field = Helper::createLanguageForArrayField($mutable_field,$const_lang_mutable_field);
                InvestMutableField::create([
                        'invest_id' => $company_invest->id,
                        'position' => $mutable_field['position']
                    ]+$lang_mutable_field);
            }

            DB::commit();
            return response()->json($company_invest->fresh());
        }catch (Exception $exception){
            DB::rollBack();
            return response()->json([
                'error' => $exception
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        CompanyInvest::findOrFail($id)->delete();
        return response()->json([
            'message' => __('message-request.company-invest.delete')
        ]);
    }
}
