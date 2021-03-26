<?php

namespace App\Http\Controllers\Investor;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class UserInfoController extends Controller
{

    public function update(UserRequest $request, $id)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            // $request->validated();
            $user = User::findOrFail($id);
            $data['avatar'] = Helper::saveImage($user->avatar, $request->file('avatar'), 'investor/avatar');
            $data['cover_photo'] =  Helper::saveImage($user->cover_photo, $request->file('cover_photo'), 'investor/cover_photo');

            $user->update($data);
            DB::commit();

            return response()->json($user->fresh(), 200);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getUserBySlug($slug){
        $user = User::where('slug',$slug)->firstOrFail();
        return response()->json($user,200);
    }

}
