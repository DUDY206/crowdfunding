<?php

namespace App\Http\Controllers\Investor;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInvestRequest;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyInvest;
use App\Models\InvestImmutableField;
use App\Models\InvestMutableField;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            CompanyInvest::orderBy('created_at', 'desc')->paginate(9)
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
            $list_company_invest_lang_request = Helper::createLanguageForArrayField($request,CompanyInvest::getLangArray(),'companyInvest');
            $company_invest = CompanyInvest::create(
                $request->except('img_url')+[
                    'img_url' => Helper::saveImage(null,$request->file('img_url'),'companyInvest/img')
                ]+
                $list_company_invest_lang_request);

            //IMMUTABLE FIELD
            $list_immutable_fields_request = $request->get('immutable_field'); //check if request has immutable field
            $lang_immutable_field = []; //array attribute to create model
            if($list_immutable_fields_request !== null){
                $lang_immutable_field =  Helper::createLanguageForArrayField($list_immutable_fields_request,InvestImmutableField::getLangArray(),'companyInvest.immutable_field');
                InvestImmutableField::create([
                    'invest_id' => $company_invest->id
                ]+$lang_immutable_field);
            }

            //MUTABLE FIELD
            $const_lang_mutable_field = InvestMutableField::getLangArray();
            $list_mutable_fields_input =  $request->get('mutable_field') ?? [];
            foreach ($list_mutable_fields_input as $mutable_field){
                $lang_mutable_field = Helper::createLanguageForArrayField($mutable_field,$const_lang_mutable_field,'companyInvest.mutable_field');
                InvestMutableField::create([
                    'invest_id' => $company_invest->id,
                    'position' => $mutable_field['position']
                ]+$lang_mutable_field);
            }
//            DB::rollBack();

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
        } catch (Exception $exception) {
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
            Helper::updateLanguageForArrayField($request,CompanyInvest::getLangArray(),$company_invest);
            $img_url = [];
            if($request->hasFile('img_url')){
                $img_url = ['img_url' => Helper::saveImage($company_invest->img_url,$request->file('img_url'),'companyInvest/img')];
            }
            $company_invest->update(
                $request->except(['img_url'])+
                $img_url
            );

            //IMMUTABLE FIELD
            $list_immutable_fields_request = $request->get('immutable_field');
            $company_immutable_field = $company_invest->fresh()->immutable_field;
            if($list_immutable_fields_request !== null)
                if($company_immutable_field !== null){
                    //edit
                    Helper::updateLanguageForArrayField($list_immutable_fields_request,InvestImmutableField::getLangArray(),$company_immutable_field);
                }else{
                    //create
                    $lang_immutable_field =  Helper::createLanguageForArrayField($list_immutable_fields_request,InvestImmutableField::getLangArray(),'companyInvest.immutable_field');
                    InvestImmutableField::create([
                            'invest_id' => $company_invest->id
                        ]+$lang_immutable_field);
                }

            //MUTABLE FIELD
            $invest_mutable_field = $company_invest->fresh()->mutable_field;
            foreach ($invest_mutable_field as $field){
                $field->delete();
            }

            $const_lang_mutable_field = InvestMutableField::getLangArray();
            $list_mutable_fields_input =  $request->get('mutable_field') ?? [];
            foreach ($list_mutable_fields_input as $mutable_field){
                $lang_mutable_field = Helper::createLanguageForArrayField($mutable_field,$const_lang_mutable_field,'companyInvest.immutable_field');
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

    public function getCompanyInvestBySlug($slug, $locale)
    {
        try {
            $slug = Language::whereField('company-invest.slug')->where($locale, $slug)->firstOrFail();
            $company_invest = CompanyInvest::whereSlug($slug->id)->firstOrFail();
            $company_invest->load(['order' => function($query) {
                $query->take(6);
                $query->with('user')->get();
            }]);

            return response()->json($company_invest);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'not_found'
            ]);
        }
    }

    public function getCompanyInvestByUser($slug, $locale)
    {
        $user = User::where('slug', $slug)->with([
            'orders' => function ($query) {
                $query->where('payment_status', 3);
            }
        ])->get();

        $orders = $user[0]->orders;

        $investId = [];

        foreach ($orders as $order) {
            array_push($investId, $order->invest_id);
        }

        $investId = array_unique($investId, 0);

        $company_invest = CompanyInvest::whereIn('id', $investId)->get();

        return response()->json($company_invest);
    }

    public function getCompanyInvestBySort($sort)
    {
        switch ($sort) {
            case 1:
                $company_invest = CompanyInvest::withCount('order')->orderBy('order_count', 'desc')->paginate(9);

                return response()->json($company_invest);
                break;
        }
    }
}
