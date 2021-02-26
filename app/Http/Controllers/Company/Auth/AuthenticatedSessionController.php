<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('company.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(LoginRequest $request)
    {
        try{
            return $request->authenticate();
        }catch (Exception $exception){
            return response()->json(['success' => false,'message'=>__('auth.failed')], 200);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        try{
            $token = $request->user('api')->token();
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
