<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegAdminRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Admin::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(RegAdminRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validated();
            $admin = Admin::create(
                $request->all(['user_name','full_name','email','phone_number'])
            +[
                'password' => Hash::make($request->get('password')),
                'avatar' => Helper::saveImage(null,$request->file('avatar'),'admin/avata')
            ]);
            DB::commit();
            return response()->json([
                $admin->fresh()
            ]);
        }catch (Exception $exception){
            DB::rollBack();
            return response()->json([
                'error' =>  $exception
            ],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            Admin::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(RegAdminRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validated();
            $admin = Admin::findOrFail($id);
            $admin->update(
                $request->all(['user_name','full_name','password','email','phone_number'])
                +[
                    'avatar' => Helper::saveImage($admin->avatar,$request->file('avatar'),'admin/avata')
                ]);
            $admin->save();
            DB::commit();
            return response()->json([
                $admin->fresh()
            ]);
        }catch (Exception $exception){
            DB::rollBack();
            return response()->json([
                'error' =>  $exception
            ],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        return response()->json([
            'success' => $admin->delete()
        ]);
    }
}
