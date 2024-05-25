<?php

namespace App\Http\Controllers\client;

use App\Models\Ward;
use App\Models\Order;
use App\Models\Product;
use App\Models\District;
use App\Models\Province;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Content;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

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
    public function checkout() {
        $user = Auth::user();
        $provinces = Province::orderBy('id', 'ASC')->get();
        $customerAddress = CustomerAddress::where('user_id', $user->id)->first();
        $district = $customerAddress ? District::find($customerAddress->district_id) : null;
        $ward = $customerAddress ? Ward::find($customerAddress->ward_id) : null;
        $data['provinces'] = $provinces;
        $data['customerAddress'] = $customerAddress;
        $data['customerDistrict'] = $district;
        $data['customerWard'] = $ward;
        return view('client.checkout', $data);
    }
    public function processCheckout(Request $request) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => 'Fix the error',
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
        // Save customer address
        $user = Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->first_name,
                'email' => $request->email,
                'province_id' => $request->province,
                'district_id' => $request->district,
                'ward_id' => $request->ward,
                'address' => $request->address,
                'phone' => $request->phone,
            ]
        );
        // Save order data
        if ($request-> payment_method == 'money') {
            $shipping = 20;
            $discount = 0;
            $subTotal = Cart::subtotal(0, '.', '');
            $grand_total = $shipping + $subTotal;

            $order = new Order;
            $order->user_id = $user->id;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total = $subTotal;
            $order->payment_method = $request->payment_method;
            // customer address
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->province_id  = $request->province;
            $order->district_id = $request->district;
            $order->ward_id = $request->ward;
            $order->address = $request->address;
            $order->phone = $request->phone;
            $order->note = $request->note;
            $order->save();

            // Save data in cart item
            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price * $item->qty;
                $orderItem->save();
                // update quantity product in productDetails
                // get size_id anh color_id
                $size = Size::where('name', $item->options->size)->first();
                $color = Color::where('name', $item->options->color)->first();

                if ($size && $color) {
                    $productDetail = ProductDetail::where('product_id', $item->id)
                                                    ->where('size_id', $size->id)
                                                    ->where('color_id', $color->id)
                                                    ->first();
                    if ($productDetail) {
                        $newQuantity = $productDetail->quantity - $item->qty;

                        if ($newQuantity >= 0) {
                            $productDetail->update(['quantity' => $newQuantity]);
                        } else {
                            // Xử lý trường hợp số lượng không đủ (ví dụ: thông báo lỗi hoặc bỏ qua)
                        }
                    }
                } else {
                    // Xử lý trường hợp không tìm thấy size hoặc color (nếu cần)
                }
            }
            Cart::destroy();
            session()->flash('success','Order successfully');
            return response()->json([
                'status'=>true,
                'orderId' => $order->id,
                'message'=>'Order save successfully',
            ]);

        }else {
        }
    }

    public function thankYouOrder() {
        return view("client.thankyou");
    }
}
