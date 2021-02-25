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
        DB::beginTransaction();
        try {
            $request->validated();
            $user = User::findOrFail($id);
            $user->update(
                $request->all(['user_name','full_name','email','phone_number','date_of_birth','description','slogan'])+[
                    'avatar' => Helper::saveImage(null,$request->file('avatar'),'investor/avatar'),
                    'cover_photo' => Helper::saveImage(null,$request->file('cover_photo'),'investor/cover_photo'),
                ]
            );
            DB::commit();
            return response()->json($user->fresh(),200);

        }catch (Exception $exception){
            DB::rollBack();
            return response()->json(['error' => $exception],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getUserBySlug($slug){
        $user = User::where('slug',$slug)->firstOrFail();
        return response()->json($user,200);
    }

}
