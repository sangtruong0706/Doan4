<?php

namespace App\Http\Controllers\client;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Size;

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
            if ($request->get('price_max') == 1000){
                $products = $products->whereBetween('price',[intval($request->get('price_min')), 100000]);
            }else {
                $products = $products->whereBetween('price',[intval($request->get('price_min')), intval($request->get('price_max'))]);
            }

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


        $products = $products->with('brand')->with('productImages')->paginate(5);

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['brandSelected'] = $brandSelected;
        $data['price_min'] = intval($request->get('price_min'));
        $data['price_max'] = (intval($request->get('price_max')) == 0) ? 1000:intval($request->get('price_max'));
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
        $product = Product::where('id', $id)->with('productImages')->with('brand')->with('productDetails')->first();
        //related product
        $relatedProducts = Product::where('brand_id', $product->brand_id)
                                    ->where('id', '!=', $id)
                                    ->with('productImages')
                                    ->take(3)
                                    ->get();
        if($product === null) {
            abort(404);
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

        // echo $id;


        return view('client.product', $data);

    }
}
