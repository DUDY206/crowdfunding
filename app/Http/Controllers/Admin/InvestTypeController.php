<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvestTypeRequest;
use App\Models\InvestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class InvestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $investType = InvestType::orderByDesc('id')->paginate(10);

        return response()->json($investType);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvestTypeRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validated();

            $lang_field = Helper::createLanguageForArrayField($request, InvestType::getLangArray(), 'investType');
            $invest_type = InvestType::create([
                'img_url' =>  Helper::saveImage(null, $request->file('img_url'), 'investType/img')
            ] + $lang_field);
            DB::commit();

            return response()->json($invest_type->fresh());
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
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
    public function update(InvestTypeRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validated();

            $invest_type = InvestType::findOrFail($id);
            $lang_field = Helper::createLanguageForArrayField($request, InvestType::getLangArray(), 'investType');
            $invest_type->update([
                'img_url' =>  Helper::saveImage($invest_type->img_url, $request->file('img_url'), 'investType/img')
            ] + $lang_field);
            DB::commit();

            return response()->json($invest_type->fresh());
        } catch (Exception $exception) {

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
        DB::beginTransaction();

        try {
            InvestType::findOrFail($id)->delete();
            DB::commit();

            return response()->json([
                'message' => __('message-request.company-invest.delete')
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }
}
