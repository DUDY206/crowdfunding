<?php

namespace App\Http\Controllers\Investor\VNPay;

use App\VnpayConfig;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\SaveCard;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CreatePayment extends Controller
{
    public function index(Request $request)
    {
        // $data = $request->all();
        // $order_id = $request->get('order_id');

        // return response()->json([
        //     'data' => $data,
        //     'order_id' => $order_id
        // ]);

        DB::beginTransaction();
        try {
//            $request->validated();

            //store order first
            $save_Card = isset($request->save_card);
            $pay_Card = isset($request->select_save_card) && $request->select_save_card != null;
            $order_id = $request->get('order_id');

            if ($order_id === null) {
                $user = $request->user('api');
                $file_path = 'storage/contract/' . $user->id . '-' . $request->get('invest_id') . '-' . Carbon::now()->format('Y-m-d-h-i-s') . '.pdf';
                PDF::setOptions(['defaultFont' => 'DejaVu Sans']);
                $file = PDF::loadHTML($request->get('contract_value'))->setWarnings(false)->save($file_path);
                $params_create = [
                    'account_id' => $user->id,
                    'contract_url' => $file_path,
                ];

                $order = Order::create(
                    $request->all(['invest_id','amount','signature','amount','payment_method','payment_status','invest_type_id']) + $params_create
                );
            } else {
                $order = Order::findOrFail($order_id);
                $order->update(
                    $request->all(['signature','payment_status','payment_method'])
                );
            }

            //payment transaction
            $vnp_TxnRef = $order->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = "Dau tu du an";
            $vnp_OrderType = "other";
            $vnp_Amount = intval($order->amount * 100);
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
                "vnp_return_url" => $_SERVER['HTTP_ORIGIN'].'/'.$request->get('locale').VnpayConfig::$vnp_Returnurl,
                "vnp_txn_ref" => $vnp_TxnRef,
                "vnp_app_user_id" => "1",
                "vnp_cancel_url" => $_SERVER['HTTP_ORIGIN'].'/'.$request->get('locale').VnpayConfig::$vnp_Returnurl,
            );

            if ($save_Card) {
                $vnp_Url = VnpayConfig::$pay_Create_Token;
                $inputSaveCard = array(
                    "vnp_command" => "pay_and_create",
                    "vnp_card_type" => "01",
                );
                $inputData = array_merge($dataSaveCard, $inputSaveCard);
            } elseif ($pay_Card) {
                $vnp_Url = VnpayConfig::$pay_Token;
                $tokenPay = SaveCard::where('id', $request->select_save_card)->get(['token'])->first();
                $inputSaveCard = array(
                    "vnp_command" => "token_pay",
                    "vnp_token" => $tokenPay->token,
                );
                $inputData = array_merge($dataSaveCard, $inputSaveCard);
            } else {
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
                    "vnp_ReturnUrl" => $_SERVER['HTTP_ORIGIN'].'/'.$request->get('locale').VnpayConfig::$vnp_Returnurl,
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
            DB::commit();

//            $returnData = array('code' => '00', 'message' => 'success', 'data' => $vnp_Url);

            return response()->json([
                'redirect' => $vnp_Url,
                'code' => '00',
                'message' => 'success'
            ]);
        } catch (Exception $exception){
            DB::rollBack();

            return response()->json([
                'code' => '001',
                'message' => 'Error payment'
            ]);
        }
    }
}
