<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterPaticipate;
use App\Mail\RegisterPaticipateMail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('investor.app');
    }

    public function registerPaticipate(RegisterPaticipate $request)
    {
        try {
            $data = $request->all();
            $mailable = new RegisterPaticipateMail($data);
            $toEmail = 'nguyentienthanh9291@gmail.com';
            Mail::to($toEmail)->send($mailable);

            return response()->json([
                'status' => true,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
            ]);
        }
    }
}
