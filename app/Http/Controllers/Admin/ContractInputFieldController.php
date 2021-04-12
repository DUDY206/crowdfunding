<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractInputFieldRequest;
use App\Models\ContractInputField;
use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;

class ContractInputFieldController extends Controller
{

    public function index()
    {
        return response()->json(
            ContractInputField::orderByDesc('id')->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContractInputFieldRequest $request)
    {
        try {
            $request->validated();
            $field = Helper::createLanguageForArrayField($request,ContractInputField::getLangArray(),'contractInputField');
            $contractInputField = ContractInputField::create($field);

            return response()->json(
                $contractInputField->fresh()
            );
        }   catch (Exception $exception){
            return response()->json([
                'error' => $exception
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContractInputFieldRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContractInputFieldRequest $request, $id)
    {
        try {
            $request->validated();
            $contractInputField = ContractInputField::findOrFail($id);
            $contractInputField->lang_field->delete();
            $field = Helper::createLanguageForArrayField($request, ContractInputField::getLangArray(), 'contractInputField');
            $contractInputField->update($field);
            $contractInputField->save();

            return response()->json(
                $contractInputField->fresh()
            );
        }   catch (Exception $exception){
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
        DB::begintransaction();
        try {
            $contractInput = ContractInputField::findOrFail($id)->delete();
            DB::commit();

            return response()->json([
                'success' => true
            ]);
        } catch (Exception $exception){
            DB::rollback();
            return response()->json([
                'error' => $exception
            ]);
        }

    }
}
