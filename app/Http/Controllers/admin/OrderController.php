<?php

namespace App\Http\Controllers\admin;

use App\Models\Ward;
use App\Models\Order;
use App\Models\District;
use App\Models\Province;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = Order::leftJoin('users', 'users.id', '=', 'orders.user_id')
                       ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
                       ->orderBy('orders.created_at', 'desc');

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $orders = $orders->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', '%'.$keyword.'%')
                      ->orWhere('users.email', 'like', '%'.$keyword.'%')
                      ->orWhere('orders.id', 'like', '%'.$keyword.'%');
            });
        }

        $orders = $orders->paginate(5);
        $data['orders'] = $orders;

        return view('admin.orders.list', $data);
    }
    public function detail($orderId) {
        $data=[];
        $provinces = Province::orderBy('id', 'asc');
        $districts = District::orderBy('id', 'asc');
        $wards = Ward::orderBy('id', 'asc');
        $order = Order::where('id', $orderId)->first();
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        $data = [
            'order' => $order,
            'orderItems' => $orderItems,
            'province' => $order->province ? $order->province->name : null,
            'district' => $order->district ? $order->district->name : null,
            'ward' => $order->ward ? $order->ward->name : null,
        ];
        return view('admin.orders.detail', $data);
    }
    public function changeOrderStatus(Request $request, $orderId) {
        $order = Order::find($orderId);
        $order->order_status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();
        session()->flash('success', 'Order change status successfully');
        return response()->json([
            'status' => true,
            'message' => 'Order changed status successfully',
        ]);
    }
}
