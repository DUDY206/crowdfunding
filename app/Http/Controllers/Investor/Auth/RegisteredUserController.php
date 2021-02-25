<?php

namespace App\Http\Controllers\Investor\Auth;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Investor\UserInfoController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('investor.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        try {
            $request->validated();
            $user = User::create(
                $request->all(['user_name','full_name','email','phone_number','date_of_birth'])+[
                    'password' =>Hash::make($request->get('password'))
                ]
            );
            $user = $user->fresh();
            event(new Registered($user));
            $token = $user->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        }catch (Exception $exception ){
            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }


//        return redirect(RouteServiceProvider::HOME);
    }
}
