<?php
namespace App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class VnpayConfig extends Controller {
    public static $vnp_TmnCode = "7MNNV6NM"; //Mã website tại VNPAY
    public static $vnp_HashSecret = "BXWHZXWXCRRLROPQGTBQISPQSCUUEUES"; //Chuỗi bí mật
    public static $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    public static $create_Token = "https://sandbox.vnpayment.vn/tokenUI/create-token.html";
    public static $pay_Create_Token = "https://sandbox.vnpayment.vn/tokenUI/pay-create-token.html";
    public static $pay_Token = "https://sandbox.vnpayment.vn/tokenUI/payment-token.html";
    public static $remove_Token = "https://sandbox.vnpayment.vn/tokenUI/remove-token.html";
    public static $vnp_Returnurl = "/payment/vnpay/success-payment";
}
