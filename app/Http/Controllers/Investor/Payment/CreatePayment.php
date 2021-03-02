<?php
namespace App\Http\Controllers\Investor\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SaveCard;
use Illuminate\Http\Request;
use App\VnpayConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreatePayment extends Controller {
    public function index(Request $request){
        DB::beginTransaction();
        try {
            $save_Card = isset($request->save_card);
            $pay_Card = isset($request->select_save_card) && $request->select_save_card != null;
            $order = new Order();
            $order->customer_id = $request->customer_id;
            $order->product_id = $request->product_id;
            $order->status = 0;
            $order->payment_method = 'vnpay';
            $order->quantity = $request->quantity;;
            $order->amount = $request->amount;
            $order->created_at = date('Y-m-d H:i:s');
            $order->save();
            DB::commit();
            $vnp_TxnRef = $order->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = $request->order_desc;
            $vnp_OrderType = "other";
            $vnp_Amount = $request->amount * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = "";
            $vnp_IpAddr = $request->ip();
            $dataSaveCard = array(
                "vnp_version" => "1.0.0",
                "vnp_tmn_code" => VnpayConfig::$vnp_TmnCode,
                "vnp_amount" => $vnp_Amount,
                "vnp_create_date" => date('YmdHis'),
                "vnp_curr_code" => "VND",
                "vnp_ip_addr" => $vnp_IpAddr,
                "vnp_txn_desc" => $vnp_OrderInfo,
                "vnp_return_url" => url(VnpayConfig::$vnp_Returnurl),
                "vnp_txn_ref" => $vnp_TxnRef,
                "vnp_app_user_id" => "1",
                "vnp_cancel_url" => url(VnpayConfig::$vnp_Returnurl)
            );

            if($save_Card) {
                $vnp_Url = VnpayConfig::$pay_Create_Token;
                $inputSaveCard = array(
                    "vnp_command" => "pay_and_create",
                    "vnp_card_type" => "01",
                );
                $inputData = array_merge($dataSaveCard, $inputSaveCard);
            }elseif ($pay_Card) {
                $vnp_Url = VnpayConfig::$pay_Token;
                $tokenPay = SaveCard::where('id', $request->select_save_card)->get(['token'])->first();
                $inputSaveCard = array(
                    "vnp_command" => "token_pay",
                    "vnp_token" => $tokenPay->token,
                );
                $inputData = array_merge($dataSaveCard, $inputSaveCard);
            }else{
                $vnp_Url = VnpayConfig::$vnp_Url;
                $inputData = array(
                    "vnp_Version" => "2.0.0",
                    "vnp_TmnCode" => VnpayConfig::$vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => url(VnpayConfig::$vnp_Returnurl),
                    "vnp_TxnRef" => $vnp_TxnRef,
                );
            }
            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . $key . "=" . $value;
                } else {
                    $hashdata .= $key . "=" . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            $vnp_HashSecret = VnpayConfig::$vnp_HashSecret;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
                $query_SecureHash = $save_Card || $pay_Card ? 'vnp_secure_hash_type=SHA256&vnp_secure_hash=' : 'vnp_SecureHashType=SHA256&vnp_SecureHash=';
                $vnp_Url .= $query_SecureHash . $vnpSecureHash;
            }
            $returnData = array('code' => '00', 'message' => 'success', 'data' => $vnp_Url);
            return json_encode($returnData);
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            DB::rollBack();
            $returnData = array('code' => '001', 'message' => "Error Payment");
            return json_encode($returnData);
        }
    }
}
