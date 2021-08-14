<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterPaticipate;
use App\Http\Requests\AppointmentInvestmentRequest;
use App\Mail\RegisterPaticipateMail;
use App\Mail\PaymentContactMail;
use App\Mail\AppointmentForInvestment;
use Illuminate\Support\Facades\Mail;
class HomeController extends Controller
{
    protected $emailBestb = 'bestb.capital@gmail.com';
    protected $emailNguyenThanh = 'nguyentienthanh9291server@gmail.com';

    public function __invoke()
    {
        return view('investor.app');
    }

    public function registerPaticipate(RegisterPaticipate $request)
    {
        try {
            $data = $request->all();
            $mailable = new RegisterPaticipateMail($data);
            $toEmail = $this->emailBestb;
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

    public function sendMailContact(Request $request)
    {
        try {
            $data = $request->all();

            $mailable = new PaymentContactMail($data);
            $toEmail = $this->emailBestb;
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

    public function makeAppointmentForInvestment(AppointmentInvestmentRequest $request)
    {
        try {
            $data = $request->all();
            $data['date'] = date('d/m/Y', strtotime($data['date']));
            $data['datetime'] = $data['time'] . ' ' . $data['date'];

            $mailable = new AppointmentForInvestment($data);
            $toEmail = $this->emailBestb;
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

    public function checkIP(Request $request)
    {
        return response()->json($request->ip());
    }
}
