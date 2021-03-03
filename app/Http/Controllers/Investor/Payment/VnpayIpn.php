<?php

namespace App\Http\Controllers\Investor\Payment;

use App\Http\Controllers\Controller;
use App\VnpayConfig;
use App\Models\Order;
use App\Models\SaveCard;
use App\Models\VnpayTransaction;
use Illuminate\Support\Facades\Log;

class VnpayIpn extends Controller {
    public function index(){
        $inputData = array();
        $returnData = array();
        $data = $_REQUEST;
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_command = isset($inputData['vnp_command']) ? $inputData['vnp_command'] : null;
        if ($vnp_command == null) {
            $vnp_SecureHash = $inputData['vnp_SecureHash'];
            unset($inputData['vnp_SecureHashType']);
            unset($inputData['vnp_SecureHash']);
            $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
            $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
            $orderId = $inputData['vnp_TxnRef'];
            $amount = $inputData['vnp_Amount'];
            $cardType = $inputData['vnp_CardType'];
            $orderInfo = $inputData['vnp_OrderInfo'];
            $payDate = $inputData['vnp_PayDate'];
            $responseCode = $inputData['vnp_ResponseCode'];
        }else{
            $vnp_SecureHash = $inputData['vnp_secure_hash'];
            unset($inputData['vnp_secure_hash_type']);
            unset($inputData['vnp_secure_hash']);
            $vnpTranId = $inputData['vnp_transaction_no']; //Mã giao dịch tại VNPAY
            $vnp_BankCode = $inputData['vnp_bank_code']; //Ngân hàng thanh toán
            $orderId = $inputData['vnp_txn_ref'];
            $amount = $inputData['vnp_amount'];
            $cardType = $inputData['vnp_card_type'];
            $orderInfo = $inputData['vnp_txn_desc'];
            $payDate = $inputData['vnp_pay_date'];
            $responseCode = $inputData['vnp_response_code'];
            $cardNumber = $inputData['vnp_card_number'];
            $cardToken = $inputData['vnp_token'];
            $customerId = $inputData['vnp_app_user_id'];
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
        $status = 0;
        $secureHash = hash('sha256',VnpayConfig::$vnp_HashSecret . $hashData);

        try {
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                if(isset($cardToken) && isset($cardNumber)) {
                    $isSaveCard = SaveCard::where('token', $cardToken)->get(['id']);
                    if (count($isSaveCard) == 0){
                        $saveCard = new SaveCard();
                        $saveCard->customer_id = $customerId;
                        $saveCard->token = $cardToken;
                        $saveCard->card_number = $cardNumber;
                        $saveCard->save();
                    }
                }
                $order = Order::find($orderId);
                if ($order->id != NULL) {
                    if (isset($order->status) && $order->status == 0) {
                        if ($responseCode == '00') {
                            $status = 1;
                        } else {
                            $status = 2;
                        }
                        $order->status = $status;
                        $order->save();
                        $returnData['RspCode'] = '00';
                        $returnData['Message'] = 'Confirm Success';
                    } else {
                        $returnData['RspCode'] = '02';
                        $returnData['Message'] = 'Order already confirmed';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }

                $transaction = new VnpayTransaction();
                $transaction->order_id = $orderId;
                $transaction->transaction_no = $vnpTranId;
                $transaction->amount = $amount;
                $transaction->card_type = $cardType;
                $transaction->order_info = $orderInfo;
                $transaction->pay_date = $payDate;
                $transaction->bank_code = $vnp_BankCode;
                $transaction->response_code = $responseCode;
                try {
                    $transaction->save();
                    Log::channel('post_history')->info("success");
                }catch (\Exception $exception) {
                    Log::channel('post_history')->info($exception->getMessage());
                }
            }
            else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Chu ky khong hop le';
            }
        } catch (\Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
//Trả lại VNPAY theo định dạng JSON
        return json_encode($returnData);
    }
}
