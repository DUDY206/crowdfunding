<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyInvest;
use App\Models\InvestType;
use Illuminate\Http\Request;
use Mockery\Exception;

class ContractHasInputFieldController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'invest_type_id' => 'required|exists:invest_types,id',
                'contract_field' => 'array'
            ]);

            $invest = InvestType::findOrFail($request->get('invest_type_id'));
            $invest->contract_input_field()->sync($request->get('contract_field'));

            return response()->json([
                'success' => true
            ], 200);

        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception
            ], 422);
        }
    }

    public function show($id)
    {
        $invest_type = InvestType::findOrFail($id);
        $list_input_field = $invest_type->contract_input_field;

        return response()->json($list_input_field);
    }
}
