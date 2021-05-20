<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestHasType;
use App\Models\CompanyInvest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class InvestHasTypeController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvestHasType $request)
    {
        try {
            $request->validated();
            $invest = CompanyInvest::findOrFail($request->get('invest_id'));
            $invest->invest_type()->sync($request->get('invest_type'));
            return response()->json([
                'success' => true
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'error' => $exception
            ],422);
        }
    }

    public function show($id)
    {
        $company_invest = CompanyInvest::findOrFail($id);

        return response()->json(
            $company_invest->array_invest_type
        );
    }

}
