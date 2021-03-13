<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestHasContractFieldRequest;
use App\Models\CompanyInvest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

class InvestHasContractFieldController extends Controller
{
    public function index()
    {
        //
    }


    public function store(InvestHasContractFieldRequest $request)
    {
        try {
            $request->validated();
            $companyInvest = CompanyInvest::findOrFail($request->get('invest_id'));
            $companyInvest->contract_field()->sync($request->get('invest_contract_field_id'));

        }catch (Exception $exception){
            return response()->json([
                'error' => $exception
            ],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function show($id)
    {
        $company_invest = CompanyInvest::findOrFail($id);
        return response()->json(
            $company_invest->contract_field
        );
    }
}
