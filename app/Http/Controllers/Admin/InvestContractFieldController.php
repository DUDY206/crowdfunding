<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvestContractFieldRequest;
use App\Models\CompanyInvest;
use App\Models\InvestContractField;
use Illuminate\Http\Request;
use Mockery\Exception;

class InvestContractFieldController extends Controller
{
    public function index(){
        return response()->json(
            InvestContractField::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvestContractFieldRequest $request)
    {
        try {
            $request->validated();
            $lang_create = Helper::createLanguageForArrayField($request,InvestContractField::getLangArray(),'invest_contract_field');
            $investcontractfield = InvestContractField::create($lang_create);
            return response()->json($investcontractfield->fresh());

        }catch (Exception $exception){
            return response()->json([
                'error'=> $exception
            ]);
        }
    }

    public function update(InvestContractFieldRequest $request,$id){
        try {
            $request->validated();
            $investcontractfield = InvestContractField::findOrFail($id);
            Helper::updateLanguageForArrayField($request,InvestContractField::getLangArray(),$investcontractfield);
            return response()->json($investcontractfield->fresh());
        }catch (Exception $exception){
            return response()->json([
                'error'=> $exception
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
}
