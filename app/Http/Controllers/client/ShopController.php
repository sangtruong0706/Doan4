<?php

namespace App\Http\Controllers\client;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null) {
        $data = [];
        $categorySelected = '';
        $brandSelected = '';

        $categories = Category::orderBy('id', 'asc')->where('status', '1')->get();
        $brands = Brand::orderBy('id', 'asc')->where('status', '1')->get();

        // Khởi tạo truy vấn sản phẩm
        $products = Product::where('status', '1');

        // filter by category
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $products->where('category_id', $category->id);
                $categorySelected = $category->id;
            }
        }

        // filter by brand
        if ($request->get('brand')) {
            $brand_ids = explode(',', $request->get('brand'));
            $products->whereIn('brand_id', $brand_ids);
            $brandSelected = $brand_ids;
        }
        //filter by price
        if ($request->get('price_max') != '' && $request->get('price_min') != ''){
            if ($request->get('price_max') == 100000000){
                $products = $products->whereBetween('price',[intval($request->get('price_min')), 100000000]);
            }else {
                $products = $products->whereBetween('price',[intval($request->get('price_min')), intval($request->get('price_max'))]);
            }

        }

        // Search product
        if (!empty($request->get('keyword'))){
            $products = $products->where('title','like','%'.$request->get('keyword').'%');
        }

        //Sorting filter
        if($request->get('sort') != ''){
            $sortSelected = $request->get('sort');
            if ($sortSelected == 'latest') {
                $products = $products->orderBy('id', 'DESC');
            } elseif ($sortSelected == 'price-ascending') {
                $products = $products->orderBy('price', 'ASC');
            } else{
                $products = $products->orderBy('price', 'DESC');
            }
        }else {
            $products = $products->orderBy('id', 'DESC');
        }



        $products = $products->with('brand')->with('productImages')->paginate(8);

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['brandSelected'] = $brandSelected;
        $data['price_min'] = intval($request->get('price_min'));
        $data['price_max'] = (intval($request->get('price_max')) == 0) ? 100000000:intval($request->get('price_max'));
        if($request->get('sort') != ''){
            $data['sortSelected'] = $sortSelected;
        }else {
            $data['sortSelected'] = '';
        }


        return view('client.shop', $data);

    }
    public function product ($id, Request $request) {
        $data = [];
        $categorySelected = '';
        $brandSelected = '';

        $colors = Color::orderBy('id', 'asc')->get();
        $sizes = Size::orderBy('id', 'asc')->get();

        $categories = Category::orderBy('id', 'asc')->where('status', '1')->get();
        $brands = Brand::orderBy('id', 'asc')->where('status', '1')->get();
        $product = Product::where('id', $id)
                            ->withCount('ratings')
                            ->withSum('ratings', 'rating')
                            ->with('productImages', 'ratings', 'brand', 'productDetails')
                            ->first();
        // dd($product);
        //related product
        $relatedProducts = Product::where('brand_id', $product->brand_id)
                                    ->where('id', '!=', $id)
                                    ->with('productImages')
                                    ->take(3)
                                    ->get();

        if($product === null) {
            abort(404);
        }


        $hasPurchased = OrderItem::where('product_id', $product->id)
            ->whereHas('order', function($query) {
                $query->where('user_id', Auth::id());
            })->exists();

        // Rating Calculator
        // "ratings_count" => 1
        // "ratings_sum_rating" => "3.0"
        $avgRating = '0.0';
        $avgRatingPer = '0';
        if ($product->ratings_count > 0) {
            $avgRating = number_format(($product->ratings_sum_rating / $product->ratings_count), 1);
            $avgRatingPer = $avgRating*100/5;
        }


        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['colors'] = $colors;
        $data['sizes'] = $sizes;
        $data['categorySelected'] = $categorySelected;
        $data['brandSelected'] = $brandSelected;
        $data['price_min'] = 0;
        $data['price_max'] = 1000;
        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        $data['hasPurchased'] = $hasPurchased;
        $data['avgRating'] = $avgRating;
        $data['avgRatingPer'] = $avgRatingPer;

        // echo $id;


        return view('client.product', $data);
    }
    public function saveRating(Request $request, $product_id) {
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
        $user = Auth::user();

        // Check user already rating
        $existingRating = ProductRating::where('user_id', $user->id)
        ->where('product_id', $request->product_id)
        ->first();

        if ($existingRating) {
        // Nếu người dùng đã đánh giá cho sản phẩm này trước đó
        session()->flash('error', 'You have already rated this product!!');
        return response()->json(['status' => true]);
        }

        $productRating = new ProductRating();
        $productRating->user_id = $user->id;
        $productRating->product_id = $product_id;
        $productRating->rating = $request->rating;
        $productRating->comment = $request->comment;
        $productRating->status = 0;
        $productRating->save();
        session()->flash('success','Thank for your rating!');
        return response()->json([
            'status' => true,
            'message' => "Rating successfully"
        ]);
    }
}
