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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ConfirmAccountMail;

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
        DB::beginTransaction();

        try {
            $request->validated();

            $user = User::create(
                $request->all([
                    'user_name',
                    'full_name',
                    'email',
                    'phone_number',
                    'date_of_birth',
                    'is_verify' => 0,
                    'code_email'
                ]) + [
                    'password' => Hash::make($request->get('password'))
                ]
            );

            $mailable = new ConfirmAccountMail($request->get('code_email'), $user->full_name);
            $toEmail = $request->get('email');
            Mail::to($toEmail)->send($mailable);

            $user = $user->fresh();
            event(new Registered($user));
            DB::commit();

            return response()->json([
                'slug' => $user->slug
            ], 200);
        } catch (Exception $exception ){
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
//        return redirect(RouteServiceProvider::HOME);
    }

    public function sendEmailConfirm(Request $request, $slug)
    {
        $data = $request->all();
        DB::beginTransaction();

        try {
            $user = User::where('slug', $data['slug'])->firstOrFail();

            $mailable = new ConfirmAccountMail($data['code_confirm'], $user->full_name);
            $toEmail = $user->email;
            Mail::to($toEmail)->send($mailable);

            $user->update([
                'is_verify' => 0,
                'code_email' => $data['code_confirm'],
            ]);
            DB::commit();

            return response()->json([
                'status' => true,
            ]);
        } catch (Exception $exception ){
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function verifyAccount(Request $request, $slug)
    {
        $data = $request->all();
        $user = User::where('slug', $data['slug'])->firstOrFail();

        if ($user->code_email === $data['code_confirm']) {
            $user->update([
                'is_verify' => 1,
                'code_email' => '',
            ]);
            $token = $user->createToken('LaravelAuthApp')->accessToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
}
