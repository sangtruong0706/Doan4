<?php

namespace App\Http\Controllers\shipper;

use App\Models\Ward;
use App\Models\Order;
use App\Models\District;
use App\Models\Province;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ShippedMail;
use Illuminate\Support\Facades\Mail;

class ShipperOrderController extends Controller
{
    public function index()
    {
        $shipper = auth()->guard('shipper')->user();

        // Lấy tất cả các đơn hàng của shipper
        $orders = Order::where('shipper_id', $shipper->id)
                        ->where('order_status', 'delivered')
                        ->get();

        // Tạo một mảng để lưu thông tin vận chuyển của tất cả các đơn hàng
        $shippingAddresses = [];

        foreach ($orders as $order) {
            // Lấy thông tin vận chuyển của mỗi đơn hàng
            $province = Province::find($order->province_id);
            $district = District::find($order->district_id);
            $ward = Ward::find($order->ward_id);

            // Lưu thông tin vận chuyển vào mảng
            $shippingAddress = [
                'province' => $province ? $province->name : '',
                'district' => $district ? $district->name : '',
                'ward' => $ward ? $ward->name : '',
            ];

            $shippingAddresses[] = $shippingAddress;
        }

        // Truyền danh sách đơn hàng và thông tin vận chuyển vào view
        $data['orders'] = $orders;
        $data['shippingAddresses'] = $shippingAddresses;

        return view('shipper.order', $data);

    }
    public function detail($order_id) {
        $data=[];
        $provinces = Province::orderBy('id', 'asc');
        $districts = District::orderBy('id', 'asc');
        $wards = Ward::orderBy('id', 'asc');
        $order = Order::where('id', $order_id)->first();
        $orderItems = OrderItem::where('order_id', $order_id)->get();
        $data = [
            'order' => $order,
            'orderItems' => $orderItems,
            'province' => $order->province ? $order->province->name : null,
            'district' => $order->district ? $order->district->name : null,
            'ward' => $order->ward ? $order->ward->name : null,
        ];
        return view('shipper.order-detail', $data);
    }
    public function orderDelivered(){
        $shipper = auth()->guard('shipper')->user();

        // Lấy tất cả các đơn hàng của shipper
        $orders = Order::where('shipper_id', $shipper->id)
                        ->where('order_status', 'shipped')
                        ->get();

        // Tạo một mảng để lưu thông tin vận chuyển của tất cả các đơn hàng
        $shippingAddresses = [];

        foreach ($orders as $order) {
            // Lấy thông tin vận chuyển của mỗi đơn hàng
            $province = Province::find($order->province_id);
            $district = District::find($order->district_id);
            $ward = Ward::find($order->ward_id);

            // Lưu thông tin vận chuyển vào mảng
            $shippingAddress = [
                'province' => $province ? $province->name : '',
                'district' => $district ? $district->name : '',
                'ward' => $ward ? $ward->name : '',
            ];

            $shippingAddresses[] = $shippingAddress;
        }

        // Truyền danh sách đơn hàng và thông tin vận chuyển vào view
        $data['orders'] = $orders;
        $data['shippingAddresses'] = $shippingAddresses;

        return view('shipper.order-delivered', $data);
    }
    public function sendMail($order_id) {
        $shipper = auth()->guard('shipper')->user();
        // dd($shipper);
        $order = Order::where('id', $order_id)->with('items', 'province', 'district', 'ward')->first();
        $orderItem = OrderItem::where('order_id', $order_id)->first();
        $mailConf = [
            'shipper_name' =>$shipper->full_name,
            'order' =>$order,
            'orderItem' =>$orderItem,
            'mail_subject' => 'You have received a confirmation order email',
        ];

        Mail::to('admin@gmail.com')->send(new ShippedMail($mailConf));
        session()->flash('success', "You already send mail to admin, please wait admin confirmation");
        return response()->json([
            'status' => true,
            'message' => 'send email successfully',
        ]);
    }
}
