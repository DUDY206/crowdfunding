<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestHasContractFieldValueRequest;
use App\Models\CompanyInvest;
use Illuminate\Http\Request;
use Mockery\Exception;

class InvestHasContractFieldValueController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvestHasContractFieldValueRequest $request)
    {
        try {
            $request->validated();
            $company_invest = CompanyInvest::findOrFail($request->get('invest_id'));
            $sync = [];

            foreach ($request->get('contract_value') as $field_id => $value) {
                $sync[$field_id] = ['value' => $value];
            }
            $company_invest->contract_field()->sync($sync);

            return response()->json([
                'success' => 1
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception
            ], 422);
        }
    }
}
