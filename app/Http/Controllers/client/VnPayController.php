<?php

namespace App\Http\Controllers\client;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;

class VnPayController extends Controller
{
    public function handleVNPayReturn(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TmnCode = "OSY652U2"; //Website ID in VNPAY System
        $vnp_HashSecret = "UQ8UR9HDIVGAB6CGDC7QAI0ORP1WVYYG"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/return/vnpay/";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";

        // Lấy dữ liệu từ URL
        $vnp_SecureHash = $request->query('vnp_SecureHash');
        $inputData = $request->query();

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            if ($request->query('vnp_ResponseCode') == '00') {
                // Xử lý logic khi giao dịch thành công
                // Bạn có thể cập nhật trạng thái đơn hàng tại đây
                // Ví dụ:
                $order = Order::find($request->query('vnp_TxnRef'));
                $order->payment_status = 'Đã thanh toán';
                $order->save();
                // Send Order Email
                OrderEmail($order->id);
                session()->forget('code');
                Cart::destroy();
                session()->flash('success', 'Thanh toán thành công!');
                return redirect()->route('client.thankYouOrder');
            } else {
                // Xử lý logic khi giao dịch không thành công
                $order = Order::find($request->query('vnp_TxnRef'));
                if ($order) {
                    // $order->orderItems()->delete();
                    $order->delete();
                }
                session()->flash('error', 'Thanh toán không thành công!');
                return redirect()->route('client.paymentFailed');
            }
        } else {
            // Xử lý khi chữ ký không hợp lệ
            Log::error('Invalid VNPAY response: ' . json_encode($request->all()));
            return redirect()->route('client.paymentFailed')->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau.');
        }
    }
}
