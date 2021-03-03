<?php

namespace App\Http\Controllers\Investor\Payment;

use App\Http\Controllers\Controller;
use App\VnpayConfig;
use Illuminate\Http\Request;

class VnpayReturn extends Controller {
    public function index(Request $request){
        $requestReturn = $request->all();
        $vnp_command = isset($requestReturn['vnp_command']) ? $requestReturn['vnp_command'] : null;
        $inputData = array();
        foreach ($requestReturn as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        if ($vnp_command == null) {
            $vnp_SecureHash = $inputData['vnp_SecureHash'];
            unset($inputData['vnp_SecureHashType']);
            unset($inputData['vnp_SecureHash']);
        }else{
            $vnp_SecureHash = $inputData['vnp_secure_hash'];
            unset($inputData['vnp_secure_hash_type']);
            unset($inputData['vnp_secure_hash']);
        }
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }
        $secureHash = hash('sha256', VnpayConfig::$vnp_HashSecret . $hashData);
        $vnp_ResponseCode = $vnp_command != null ? $requestReturn['vnp_response_code'] : $requestReturn['vnp_ResponseCode'];
        return view("vnpay_return", compact(['vnp_SecureHash', 'secureHash', 'vnp_ResponseCode']));
    }
}
