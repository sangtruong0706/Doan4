<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){

        $totalOrders = Order::where('order_status', '!=', 'cancelled')->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('roleID',1)->count();
        $totalRevenue = Order::where('order_status', '!=', 'cancelled')->sum('grand_total');

        // This month revenue
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $revenueThisMonth = Order::where('order_status', '!=' ,'cancelled')
                                    ->whereDate('created_at', '>=' ,$startOfMonth)
                                    ->whereDate('created_at', '<=' ,$currentDate)
                                    ->sum('grand_total');

        $data['totalOrders'] = $totalOrders;
        $data['totalProducts'] = $totalProducts;
        $data['totalCustomers'] = $totalCustomers;
        $data['totalRevenue'] = $totalRevenue;
        $data['revenueThisMonth'] = $revenueThisMonth;

        return view('admin.dashboard', $data);
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
