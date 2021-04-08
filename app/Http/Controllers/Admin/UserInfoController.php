<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::orderByDesc('id')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['avatar'] = Helper::saveImage(null, $request->file('avatar'), 'investor/avatar');
        $data['cover_photo'] =  Helper::saveImage(null, $request->file('cover_photo'), 'investor/cover_photo');

        DB::beginTransaction();

        try {
            $user = User::create($data);
            $user = $user->fresh();
            DB::commit();

            return response()->json($user, 200);
        } catch (Exception $exception){
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();

        $data = $request->all();
        $data['slug'] = $data['user_name'] . '-' . $id;

        try {
            $user = User::findOrFail($id);
            if ($data['password'] == "undefined") {
                $data['password'] = $user->password;
            } else {
                $data['password'] = Hash::make($request->password);
            }
            $data['avatar'] = Helper::saveImage($user->avatar, $request->file('avatar'), 'investor/avatar');
            $data['cover_photo'] =  Helper::saveImage($user->cover_photo, $request->file('cover_photo'), 'investor/cover_photo');

            $user->update($data);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'update success'
            ]);
        } catch (Exception $exception){
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            User::findOrFail($id)->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'delete success'
            ]);
        } catch (Exception $exception){
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
