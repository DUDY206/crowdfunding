<?php

namespace App\Http\Controllers\Investor;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\Investor\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Illuminate\Support\Facades\Hash;

class UserInfoController extends Controller
{

    public function update(UserRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = $data['user_name'] . '-' . $id;

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $data['avatar'] = Helper::saveImage($user->avatar, $request->file('avatar'), 'investor/avatar');
            $data['cover_photo'] =  Helper::saveImage($user->cover_photo, $request->file('cover_photo'), 'investor/cover_photo');

            $user->update($data);
            DB::commit();

            return response()->json($user->fresh(), 200);

        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function changePassword(ChangePasswordRequest $request, $id)
    {
        $data = $request->all();
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            if ($user) {
                if (Hash::check($data['old_password'], $user->password)) {
                    if ($data['new_password'] === $data['repassword']) {
                        $data['new_password'] = Hash::make($data['new_password']);
                        $user->update([
                            'password' => $data['new_password'],
                        ]);
                        DB::commit();

                        return response()->json([
                            'status' => true,
                            'message' => 'Change password successfully',
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'The new password and Re-enter the new password do not match',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Incorrect old password',
                    ]);
                }
            }
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getUserBySlug($slug){
        $user = User::where('slug', $slug)->firstOrFail();

        return response()->json($user, 200);
    }

}
