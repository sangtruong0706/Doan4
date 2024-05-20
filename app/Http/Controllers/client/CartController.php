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
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        $total =0;
        $subTotal = 0;
        foreach (Cart::content() as $item) {
            $total = $item->qty * $item->price;
            $subTotal += $total;
            $dataCart[] = [
                'rowId' => $item->rowId,
                'product_id' => $item->id,
                'qty' => $item->qty,
                'price' => $item->price,
                'total' => $item->qty * $item->price
            ];
        }
        return response()->json([
            'status' => true,
            'data' => [
                'cart_items' => $dataCart,
                'subtotal' => $subTotal,
                'total' => $total
            ],
        ]);
    }
    public function deleteItem (Request $request) {
        $cartInfo = Cart::get($request->rowId);
        $id_product = $cartInfo->id;
        if ($cartInfo == null) {
            return response()->json([
                'status' => false,
                'message' =>'Cart item not found'
            ]);
        }
        Cart::remove($request->rowId);
        $subtotal = Cart::subtotal();
        $shippingCost = 20;
        if (Cart::count() == 0) {
            $orderTotal = 0;
        } else {
            $orderTotal = $subtotal + $shippingCost;
        }

        return response()->json([
            'status' => true,
            'message' => 'Delete item successfully',
            'data' => [
                'product_id' => $id_product,
                'subtotal' => $subtotal,
                'ordertotal' => $orderTotal
            ],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Delete item successfully',
            'data' => [
                'product_id' => $id_product,
            ],
        ]);
    }
}
