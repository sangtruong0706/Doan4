<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request) {
        // Validate request data
        $request->validate([
            'id' => 'required|exists:products,id',
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);
        $product = Product::with('productImages', 'brand')->find($request->id);
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ]);
        }
        if (Cart::count() > 0 ) {
            // echo "Product is already added";
            $cartContent = Cart::content();
            $productAlreadyExists = false;
            foreach ($cartContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExists = true;
                };
            }
            if ($productAlreadyExists == false) {
                // Cart::add($product->id, $product->title,1, $product->price, ['productImages' => (!empty($product->productImages)) ? $product->productImages->first() : ''], ['product_brand'=>$product->brand->name] );
                Cart::add([
                    'id' => $product->id,
                    'name' => $product->title,
                    'qty' => $request->quantity,
                    'price' => $product->price,
                    'options' => [
                        'size' => $request->size,
                        'color' => $request->color,
                        'productImages' => (!empty($product->productImages)) ? $product->productImages->first() : '',
                        'product_brand' => $product->brand->name,
                    ]
                ]);
                $status = true;
                $message =  $product->title.' added successfully';
            }else {
                $status = false;
                $message =  $product->title.' already added in cart';
            }

        }else {
            // echo "Cart is empty now add new product";
            // Cart is empty
            // Cart::add($product->id, $product->title,1, $product->price, ['productImages' => (!empty($product->productImages)) ? $product->productImages->first() : ''], ['product_brand'=>$product->brand->name] );
            Cart::add([
                'id' => $product->id,
                'name' => $product->title,
                'qty' => $request->quantity,
                'price' => $product->price,
                'options' => [
                    'size' => $request->size,
                    'color' => $request->color,
                    'productImages' => (!empty($product->productImages)) ? $product->productImages->first() : '',
                    'product_brand' => $product->brand->name,
                ]
            ]);

            $status = true;
            $message =  $product->title.' added successfully';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);

    }
    public function cart() {
        // dd(Cart::content());
        // Cart::destroy();
        $cartContent = Cart::content();
        $data['cartContent'] = $cartContent;
        return view('client.cart', $data);
    }
    public function updateCart(Request $request) {

    }
}
