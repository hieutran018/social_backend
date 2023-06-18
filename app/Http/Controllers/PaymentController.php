<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getResult(Request $request)
    {
        $vnpResponseCode = $request->input('vnp_ResponseCode');
        $vnpTxnRef = $request->input('vnp_TxnRef');

        // kiểm tra kết quả thanh toán và cập nhật trạng thái đơn hàng trong cơ sở dữ liệu

        return response()->json(['message' => 'success']);
    }
    //! Sai chữ ký
    public function createPaymentRequest(Request $request)
    {
        // tạo request để lấy token
        $vnp_TxnRef = rand(1, 10000);
        $startTime = Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis');
        $expire = Carbon::parse($startTime)->addMinutes(15)->format('YmdHis');
        $url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $returnUrl = 'http://localhost:3000/return';
        $tmnCode = 'EQMILBFF';
        $secretKey = 'FOIOKSOJEVQMTIZUWYMUCVCBXYBMPAXS';
        $data = [
            "vnp_Amount" => 50000 * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => '127.0.0.1',
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => 'THANHTOANHOADON',
            "vnp_OrderType" => '26000',
            "vnp_ReturnUrl" => $returnUrl,
            "vnp_TmnCode" => $tmnCode,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_Version" => "2.1.0",
            "vnp_ExpireDate" => $expire,
        ];
        ksort($data);
        $hmacData = '';
        foreach ($data as $key => $value) {
            $hmacData .= $key . '=' . $value . '&';
        }
        $hmacData = rtrim($hmacData, '&');

        // mã hóa chuỗi mã hóa bằng secret key
        $signature = hash_hmac('SHA512', $hmacData, $secretKey);

        // thêm chữ ký vào request
        $data['vnp_SecureHash'] = $signature;
        return response()->json([
            'url' => $url . '?' . http_build_query($data)
        ]);
    }
}
