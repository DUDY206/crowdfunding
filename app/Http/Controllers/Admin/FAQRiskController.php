<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\FAQRiskRequest;
use App\Models\CompanyInvest;
use App\Models\FAQ;
use App\Models\Risks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class FAQRiskController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FAQRiskRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validated();
            $invest_id = $request->get('invest_id');
            $investment = CompanyInvest::findOrFail($invest_id);
            $is_faq = $request->get('is_faq');
            if($is_faq){
                foreach ($investment->faq as $faq){
                    $faq->delete();
                }

                $list_faq_input =  $request->get('faq') ?? [];
                $const_lang_faq = FAQ::getLangArray();
                foreach ($list_faq_input as $faq){
                    $faq_lang = Helper::createLanguageForArrayField($faq,$const_lang_faq,'companyInvest.faq');
                    $faq_created = FAQ::create([
                            'invest_id' => $invest_id
                        ] + $faq_lang);
                }
                $json_response = $investment->faq;
            }else{
                foreach ($investment->risks as $risk){
                    $risk->delete();
                }
                $list_risk_input =  $request->get('risk') ?? [];
                $const_lang_risk = Risks::getLangArray();
                foreach ($list_risk_input as $risk){
                    $risk_lang = Helper::createLanguageForArrayField($risk,$const_lang_risk,'companyInvest.risk');
                    $risk_created = Risks::create([
                            'invest_id' => $invest_id
                        ] + $risk_lang);
                }
                $json_response = $investment->risks;
            }
            DB::commit();
            return response()->json($json_response);
        }catch (Exception $exception){
            DB::rollBack();
            return response()->json([
                'error' => $exception
            ],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
