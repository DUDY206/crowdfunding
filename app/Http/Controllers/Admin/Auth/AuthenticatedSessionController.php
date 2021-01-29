<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Illuminate\Support\Facades\Cookie;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request)
    {
        try {
            return $request->authenticate();
        } catch (Exception $exception) {
            return response()->json(['success' => false,'message'=>__('auth.failed')], 200);
        }

    }
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try{
            $token = $request->user('admin')->token();
            $token->revoke();
            return response()->json([
                'success' => true,
            ]);
        }catch (Exception $exception){
            return response()->json([
                'success' => false,
                'msg' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

}
