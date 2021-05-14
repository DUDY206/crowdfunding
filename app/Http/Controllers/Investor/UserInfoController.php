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
    public $fillableUser = [
        'id',
        'user_name',
        'slug',
        'full_name',
        'email',
        'phone_number',
        'date_of_birth',
        'avatar',
        'cover_photo',
        'description',
        'slogan',
        'created_at'
    ];

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

            return response()->json([
                'status' => true,
                'message' => 'update info success'
            ]);

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
                            'message' => 'change_pass_success',
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'not_same_password',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'incorrect_old_pass',
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

    public function getUserBySlug($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail($this->fillableUser);

        return response()->json($user, 200);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function checkEmail($email)
    {
        $user = User::where('email', $email)->get();

        return response()->json($user);
    }
}
