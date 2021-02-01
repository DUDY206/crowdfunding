<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Company::paginate('10'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompanyRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validated();
            $lang_description = [];
            $lang_company_type = [];
            $lang_location = [];
            $lang_name = Helper::createLanguage($request,'name_vi','name_en','companies.name');
            //check if request has description
            $lang = Helper::createLanguage($request,'description_vi','description_en','companies.description');
            if($lang != null) $lang_description = ['description' => $lang->id];
            //check if request has company type
            $lang = Helper::createLanguage($request,'company_type_vi','company_type_en','companies.company_type');
            if($lang != null) $lang_company_type = ['company_type' => $lang->id];

            $lang = Helper::createLanguage($request,'location_vi','location_en','companies.location');
            if($lang != null) $lang_location = ['location' => $lang->id];

            $company = Company::create(
                $request->except(['name_vi','name_en','description_vi','description_en','company_type_vi','company_type_en','img_url'])+[
                'name' => $lang_name->id,
                'img_url' => Helper::saveImage(null,$request->file('img_url'),'company/img')
                ]+
                $lang_description+
                $lang_company_type+
                $lang_location
            );
            DB::commit();
            return response()->json($company->fresh());
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
            $company = Company::findOrFail($id);
            return response()->json($company);
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
    public function update(CompanyRequest $request, $id)
    {
        DB::beginTransaction();
        $company = Company::findOrFail($id);
        try {
            $request->validated();
            $lang_description = [];
            $lang_company_type = [];
            $lang_name = $company->lang_name->update([
                'vi' => $request->get('name_vi'),
                'en' => $request->get('name_en'),
            ]);
            //check if request has description
            if($request->has('description_vi') || $request->has('description_en')){
                $lang = new Language();
                if ($company->description != null){
                    $lang = Language::findOrFail($company->description);
                }
                $lang->vi = $request->get('description_vi');
                $lang->en = $request->get('description_en');
                $lang->field = 'companies.description';
                $lang->save();
                $lang_description = [
                    'description' => $lang->id
                ];
            }
            //check if request has company type
            if($request->has('company_type_vi') || $request->has('company_type_en')){
                $lang = new Language();
                if ($company->description != null){
                    $lang = Language::findOrFail($company->company_type);
                }
                $lang->vi = $request->get('company_type_vi');
                $lang->en = $request->get('company_type_en');
                $lang->field = 'companies.company_type';
                $lang->save();
                $lang_company_type = [
                    'company_type' => $lang->id
                ];
            }
            $company->update(
                $request->except(['name_vi','name_en','description_vi','description_en','company_type_vi','company_type_en','img_url'])+[
                    'img_url' => Helper::saveImage($company->img_url,$request->file('img_url'),'company/img')
                ]+
                $lang_description+
                $lang_company_type
            );
            DB::commit();
            return response()->json($company->fresh());
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
        Company::findOrFail($id)->delete();
        return response()->json([
            'message' => __('message-request.company.delete')
        ]);
    }
}
