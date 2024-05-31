<?php

namespace App\Http\Controllers\client;

use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index () {
        $data = [];
        $categories_index = Category::whereIn('name', ['Mens', 'Womans', 'Sports'])->get();
        $features_products = Product::orderBy('id','DESC')
                                    ->with('brand')
                                    ->with('productImages')
                                    ->where('is_feature', 'Yes')
                                    ->where('status', '1')
                                    ->take(4)
                                    ->get();

        $latest_products = Product::orderBy('id','DESC')
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
    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Product::where('title', 'LIKE', '%'. $query. '%')->get();
        return response()->json($filterResult);
    }
    public function addToWishList(Request $request) {
        if (Auth::check() == false) {

            session(['url.intended' => url()->previous()]);

            return response()->json([
                'status' => false,
                'message' => 'Please login to add this product wishlist',
            ]);
        }
        Wishlist::updateOrCreate(
            [
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            ],
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
            ]
            );
        // $wishlist = new Wishlist();
        // $wishlist->user_id = Auth::user()->id;
        // $wishlist->product_id = $request->product_id;
        // $wishlist->save();
        // session()->flash('success', 'Product wishlist added successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product wishlist added successfully',
        ]);
    }
}
