<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractTemplateRequest;
use App\Models\ContractTemplate;
use Illuminate\Http\Request;
use Mockery\Exception;

class ContractTemplateController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContractTemplateRequest $request)
    {
        try {
            $request->validated();
            $contract_template = ContractTemplate::create($request->all());

            return  response()->json($contract_template);
        } catch (Exception $exception) {
            return  response()->json([
                'error' => $exception
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
    public function update(ContractTemplateRequest $request, $id)
    {
        $contract_template = ContractTemplate::findOrFail($id);

        try {
            $request->validated();
            $contract_template->update($request->all());

            return response()->json($contract_template->fresh());
        } catch (Exception $exception) {
            return  response()->json([
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
        $contract_template = ContractTemplate::findOrFail($id);
        return response()->json([
            'success' => $contract_template->delete()
        ]);
    }
}
