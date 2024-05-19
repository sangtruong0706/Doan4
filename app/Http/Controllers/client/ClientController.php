<?php

namespace App\Http\Controllers\client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ClientController extends Controller
{
    public function index () {
        $data = [];
        $categories_index = Category::whereIn('name', ['Mens', 'Womans', 'Sports'])->get();
        $features_products = Product::with('brand')
                                    ->with('productImages')
                                    ->where('is_feature', 'Yes')
                                    ->where('status', '1')
                                    ->take(4)
                                    ->get();

        $latest_products = Product::orderBy('id','ASC')
                                    ->with('brand')
                                    ->with('productImages')
                                    ->where('status', '1')
                                    ->take(4)
                                    ->get();

        $data['categories_index'] = $categories_index;
        $data['features_products'] = $features_products;
        $data['latest_products'] = $latest_products;
        return view('client.home', $data);
    }
}
