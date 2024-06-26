<?php

namespace App\Http\Controllers\client;

use App\Models\Size;
use App\Models\Ward;
use App\Models\Color;
use App\Models\Order;
use App\Classes\VnPay;
use App\Models\Product;
use App\Models\District;
use App\Models\Province;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\DiscountCoupon;
use App\Models\ShippingCharge;
use Illuminate\Support\Carbon;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Content;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $vnpay;
    public function __construct(VnPay $vnpay) {
        $this->vnpay = $vnpay;
    }

    public function addToCart(Request $request) {
        // Validate request data
        $request->validate([
            'id' => 'required|exists:products,id',
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);
        $product = Product::with('productImages', 'brand')->find($request->id);
        $size = $request->size;
        $color = $request->color;
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ]);
        }
        // if (Cart::count() > 0 ) {
        //     $cartContent = Cart::content();
        //     $productAlreadyExists = false;
        //     foreach ($cartContent as $item) {
        //         if ($item->id == $product->id) {
        //             $productAlreadyExists = true;
        //         };
        //     }
        //     if ($productAlreadyExists == false) {
        //         Cart::add([
        //             'id' => $product->id,
        //             'name' => $product->title,
        //             'qty' => $request->quantity,
        //             'price' => $product->price,
        //             'options' => [
        //                 'size' => $request->size,
        //                 'color' => $request->color,
        //                 'productImages' => (!empty($product->productImages)) ? $product->productImages->first() : '',
        //                 'product_brand' => $product->brand->name,
        //             ]
        //         ]);
        //         $status = true;
        //         $message =  $product->title.' added successfully';
        //     }else {
        //         $status = false;
        //         $message =  $product->title.' already added in cart';
        //     }

        // }else {
        //     // echo "Cart is empty now add new product";
        //     // Cart is empty
        //     // Cart::add($product->id, $product->title,1, $product->price, ['productImages' => (!empty($product->productImages)) ? $product->productImages->first() : ''], ['product_brand'=>$product->brand->name] );
        //     Cart::add([
        //         'id' => $product->id,
        //         'name' => $product->title,
        //         'qty' => $request->quantity,
        //         'price' => $product->price,
        //         'options' => [
        //             'size' => $request->size,
        //             'color' => $request->color,
        //             'productImages' => (!empty($product->productImages)) ? $product->productImages->first() : '',
        //             'product_brand' => $product->brand->name,
        //         ]
        //     ]);

        //     $status = true;
        //     $message =  $product->title.' added successfully';
        // }
        if (Cart::count() > 0) {
            $cartContent = Cart::content();
            $productAlreadyExists = false;

            foreach ($cartContent as $item) {
                if ($item->id == $product->id &&
                    $item->options['size'] == $size &&
                    $item->options['color'] == $color) {
                    $productAlreadyExists = true;
                    // Tăng số lượng của sản phẩm đã tồn tại trong giỏ hàng
                    Cart::update($item->rowId, $item->qty + $request->quantity);
                    $message = $product->title . ' quantity updated in cart';
                    $status = true;
                    break; // Thoát khỏi vòng lặp sau khi đã cập nhật số lượng
                }
            }

            if (!$productAlreadyExists) {
                // Thêm sản phẩm mới vào giỏ hàng nếu chưa tồn tại
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
                $message =  $product->title . ' added successfully';
            }
        } else {
            // Nếu giỏ hàng trống, thêm sản phẩm vào giỏ hàng
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
            $message =  $product->title . ' added successfully';
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
            session()->flash('error', 'Cart item not found');
            return response()->json([
                'status' => false,
                'message' =>'Cart item not found'
            ]);
        }
        Cart::remove($request->rowId);
        $subtotal = Cart::subtotal(0, '.', '');
        $shippingCost = 0;
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

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Delete item successfully',
        //     'data' => [
        //         'product_id' => $id_product,
        //     ],
        // ]);
    }
    public function checkout() {
        // if cart is empty redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route("client.cart");
        }
        // if user is not logged redirect to login page
        if (Auth::check() == false) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route("account.login");
        }
        $discount = 0;
        $subTotal = Cart::subtotal(0, '.', '');
        if (session()->has('code')) {
            $code = session()->get('code');
            $coupon = DiscountCoupon::where('code',$code)->first();
            if ($coupon) {
                if ($coupon->type == 'percent') {
                    $discount = ($coupon->discount_amount / 100) * $subTotal;
                } else {
                    $discount = $coupon->discount_amount;
                }
            }
        }
        $user = Auth::user();
        $provinces = Province::orderBy('id', 'ASC')->get();
        $customerAddress = CustomerAddress::where('user_id', $user->id)->first();
        $district = $customerAddress ? District::find($customerAddress->district_id) : null;
        $ward = $customerAddress ? Ward::find($customerAddress->ward_id) : null;
        $data['provinces'] = $provinces;
        $data['customerAddress'] = $customerAddress;
        $data['customerDistrict'] = $district;
        $data['customerWard'] = $ward;
        $data['discount'] = $discount;
        $data['user'] = $user;

        // calculate shipping charges
        if ($customerAddress == null){
            $data['provinces'] = $provinces;
            $data['shippingCharge'] = 0;
            $data['grandTotal'] = $subTotal;
        }else{
            $userProvince = $customerAddress->province_id;
            $shippingCharge = ShippingCharge::where('province_id', $userProvince)->first();
            if ($discount > 0) {
                $grandTotal = ($subTotal-$discount) + $shippingCharge->amount;
            }else {
                $grandTotal = $subTotal + $shippingCharge->amount;
            }

            $data['shippingCharge'] = $shippingCharge->amount;
            $data['grandTotal'] = $grandTotal;
        }
        return view('client.checkout', $data);
    }
    // public function processCheckout(Request $request) {
    //     // Validate data
    //     $validator = Validator::make($request->all(), [
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => 'required',
    //         'province' => 'required|numeric|min:1',
    //         'district' => 'required|numeric|min:1',
    //         'ward' => 'required|numeric|min:1',
    //         'address' => 'required',
    //         'phone' => 'required',
    //     ]);

    //     if ($validator->fails()){
    //         return response()->json([
    //             'message' => 'Fix the error',
    //             'status' => false,
    //             'errors' => $validator->errors(),
    //         ]);
    //     }
    //     // Save customer address
    //     $user = Auth::user();
    //     CustomerAddress::updateOrCreate(
    //         ['user_id' => $user->id],
    //         [
    //             'user_id' => $user->id,
    //             'first_name' => $request->first_name,
    //             'last_name' => $request->first_name,
    //             'email' => $request->email,
    //             'province_id' => $request->province,
    //             'district_id' => $request->district,
    //             'ward_id' => $request->ward,
    //             'address' => $request->address,
    //             'phone' => $request->phone,
    //         ]
    //     );
    //     $discount_code_id = NULL;
    //     $discount_code = NULL;
    //     $discount = 0;
    //     $subTotal = Cart::subtotal(0, '.', '');
    //     if (session()->has('code')) {
    //         $code = session()->get('code');
    //         $coupon = DiscountCoupon::where('code',$code)->first();
    //         if ($coupon) {
    //             $discount_code_id = $coupon->id;
    //             $discount_code = $coupon->code;
    //             if ($coupon->type == 'percent') {
    //                 $discount = ($coupon->discount_amount / 100) * $subTotal;
    //             } else {
    //                 $discount = $coupon->discount_amount;
    //             }
    //         }
    //     }
    //     // Save order data
    //     if ($request-> payment_method == 'cod') {
    //         $shipping = $request->shipping_charge;
    //         $subTotal = Cart::subtotal(0, '.', '');
    //         $grand_total = ($subTotal- $discount) + $shipping;
    //         $order = new Order;
    //         $order->user_id = $user->id;
    //         $order->subtotal = $subTotal;
    //         $order->shipping = $shipping;
    //         $order->grand_total = $grand_total;
    //         $order->discount = $discount;
    //         $order->coupon_code_id = $discount_code_id;
    //         $order->coupon_code = $discount_code;
    //         $order->payment_method = $request->payment_method;
    //         // customer address
    //         $order->first_name = $request->first_name;
    //         $order->last_name = $request->last_name;
    //         $order->email = $request->email;
    //         $order->province_id  = $request->province;
    //         $order->district_id = $request->district;
    //         $order->ward_id = $request->ward;
    //         $order->address = $request->address;
    //         $order->phone = $request->phone;
    //         $order->note = $request->note;
    //         $order->save();

    //         // Save data in cart item
    //         foreach (Cart::content() as $item) {
    //             $orderItem = new OrderItem;
    //             $orderItem->order_id = $order->id;
    //             $orderItem->product_id = $item->id;
    //             $orderItem->name = $item->name;
    //             $orderItem->qty = $item->qty;
    //             $orderItem->size = $item->options->size;
    //             $orderItem->color = $item->options->color;
    //             $orderItem->price = $item->price;
    //             $orderItem->total = $item->price * $item->qty;
    //             $orderItem->save();
    //             // update quantity product in productDetails
    //             // get size_id anh color_id
    //             $size = Size::where('name', $item->options->size)->first();
    //             $color = Color::where('name', $item->options->color)->first();

    //             if ($size && $color) {
    //                 $productDetail = ProductDetail::where('product_id', $item->id)
    //                                                 ->where('size_id', $size->id)
    //                                                 ->where('color_id', $color->id)
    //                                                 ->first();
    //                 if ($productDetail) {
    //                     $newQuantity = $productDetail->quantity - $item->qty;

    //                     if ($newQuantity >= 0) {
    //                         $productDetail->update(['quantity' => $newQuantity]);
    //                     } else {
    //                         // Xử lý trường hợp số lượng không đủ (ví dụ: thông báo lỗi hoặc bỏ qua)
    //                     }
    //                 }
    //             } else {
    //                 // Xử lý trường hợp không tìm thấy size hoặc color (nếu cần)
    //             }
    //         }
    //         // Send Order Email
    //         OrderEmail($order->id);

    //         session()->forget('code');
    //         Cart::destroy();
    //         session()->flash('success','Order successfully');
    //         return response()->json([
    //             'status'=>true,
    //             'orderId' => $order->id,
    //             'message'=>'Order save successfully',
    //         ]);

    //     }elseif ($request-> payment_method == 'vnpay') {
    //         $shipping = $request->shipping_charge;
    //         $subTotal = Cart::subtotal(0, '.', '');
    //         $grand_total = ($subTotal- $discount) + $shipping;
    //         $order = new Order;
    //         $order->user_id = $user->id;
    //         $order->subtotal = $subTotal;
    //         $order->shipping = $shipping;
    //         $order->grand_total = $grand_total;
    //         $order->discount = $discount;
    //         $order->coupon_code_id = $discount_code_id;
    //         $order->coupon_code = $discount_code;
    //         $order->payment_method = $request->payment_method;
    //         // customer address
    //         $order->first_name = $request->first_name;
    //         $order->last_name = $request->last_name;
    //         $order->email = $request->email;
    //         $order->province_id  = $request->province;
    //         $order->district_id = $request->district;
    //         $order->ward_id = $request->ward;
    //         $order->address = $request->address;
    //         $order->phone = $request->phone;
    //         $order->note = $request->note;
    //         $order->save();
    //         // Save data in cart item
    //         foreach (Cart::content() as $item) {
    //             $orderItem = new OrderItem;
    //             $orderItem->order_id = $order->id;
    //             $orderItem->product_id = $item->id;
    //             $orderItem->name = $item->name;
    //             $orderItem->qty = $item->qty;
    //             $orderItem->size = $item->options->size;
    //             $orderItem->color = $item->options->color;
    //             $orderItem->price = $item->price;
    //             $orderItem->total = $item->price * $item->qty;
    //             $orderItem->save();
    //             // update quantity product in productDetails
    //             // get size_id anh color_id
    //             $size = Size::where('name', $item->options->size)->first();
    //             $color = Color::where('name', $item->options->color)->first();

    //             if ($size && $color) {
    //                 $productDetail = ProductDetail::where('product_id', $item->id)
    //                                                 ->where('size_id', $size->id)
    //                                                 ->where('color_id', $color->id)
    //                                                 ->first();
    //                 if ($productDetail) {
    //                     $newQuantity = $productDetail->quantity - $item->qty;

    //                     if ($newQuantity >= 0) {
    //                         $productDetail->update(['quantity' => $newQuantity]);
    //                     } else {
    //                         // Xử lý trường hợp số lượng không đủ (ví dụ: thông báo lỗi hoặc bỏ qua)
    //                     }
    //                 }
    //             } else {
    //                 // Xử lý trường hợp không tìm thấy size hoặc color (nếu cần)
    //             }
    //         }
    //         $response = $this->vnpay->payment($order);
    //         return response()->json([
    //             'status' => true,
    //             'url' => $response['url'],
    //         ]);


    //     }
    // }

    public function thankYouOrder() {
        return view("client.thankyou");
    }
    public function paymentFailed() {
        return view("client.paymentFailed");
    }


    public function getShippingCharge($province_id) {

        if ($province_id > 0) {
            $subTotal = Cart::subtotal(0, '.', '');
            $shippingInfo = ShippingCharge::where('province_id', $province_id)->first();
            $discount = 0;
            $discountString = '';
            if (session()->has('code')) {
                $code = session()->get('code');
                $coupon = DiscountCoupon::where('code',$code)->first();
                if ($coupon) {
                    if ($coupon->type == 'percent') {
                        $discount = ($coupon->discount_amount / 100) * $subTotal;
                    } else {
                        $discount = $coupon->discount_amount;
                    }
                }
                $discountString = ' <div id="discount-response" class="input-group apply-coupon" style="margin-top: 25px;">
                                    <strong>'. session()->get('code').'</strong>
                                    <button id="removeDiscount" class="mx-2"><i class="fa-solid fa-x"></i></button>
                                </div>';
            }

            if ($shippingInfo != null) {
                $shippingCharge = $shippingInfo->amount;
                if ($discount > 0) {
                    $grandTotal = ($subTotal-$discount) + $shippingCharge;
                }else {
                    $grandTotal = $subTotal + $shippingCharge;
                }
                return response()->json([
                    'status' =>true,
                    'shipping_charge' => $shippingCharge,
                    'discount' => $discount,
                    'discount_format' => number_format($discount, 0, ',', '.'). ' vnđ',
                    'shipping_charge_input' => number_format($shippingCharge, 0, ',', '.'),
                    'shipping_charge_formatted' => number_format($shippingCharge, 0, ',', '.') . ' vnđ',
                    'grand_total' => $grandTotal,
                    'grand_total_formatted' => number_format($grandTotal, 0, ',', '.') . ' vnđ',
                    'discountString' => $discountString,
                ]);
            }
        }else {
            $subTotal = Cart::subtotal(0, '.', '');
            $grandTotal = $subTotal;
            return response()->json([
                'status' =>true,
                'shipping_charge' => 0,
                'shipping_charge_input' => number_format(0, 0, ',', '.'),
                'shipping_charge_formatted' => number_format(0, 0, ',', '.') . ' vnđ',
                'grand_total' => $grandTotal,
                'grand_total_formatted' => number_format($grandTotal, 0, ',', '.') . ' vnđ',
            ]);
        }
    }
    public function applyDiscount($province_id, $code) {
        $discountCoupon = DiscountCoupon::where('code', $code)->first();
        if ($discountCoupon == null) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon code not found',
            ]);
        }
        // Check coupon start date invalid or not
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if ($discountCoupon->starts_at != " ") {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $discountCoupon->starts_at);
            if ($now->lt($startDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Discount coupon is not valid yet',
                ]);
            }
        }
        if ($discountCoupon->expires_at != " ") {
            $expiresDate = Carbon::createFromFormat('Y-m-d H:i:s', $discountCoupon->expires_at);
            if ($now->gt($expiresDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Discount coupon has expired',
                ]);
            }
        }

        // Tính toán lại tổng giá trị đơn hàng
        $shippingCharge = ShippingCharge::where('province_id', $province_id)->first();
        $shippingAmount = $shippingCharge ? $shippingCharge->amount : 0;
        $subTotal = Cart::subtotal(0, '.', '');
        $discount = 0;
        if ($discountCoupon->type == 'percent') {
            $discount = ($discountCoupon->discount_amount / 100) * $subTotal;
        } else {
            $discount = $discountCoupon->discount_amount;
        }
        $grandTotal = ($subTotal - $discount) + $shippingAmount;
        $discountString = ' <div id="discount-response" class="input-group apply-coupon" style="margin-top: 25px;">
                            <strong>'.$discountCoupon->code.'</strong>
                            <button id="removeDiscount" class="mx-2"><i class="fa-solid fa-x"></i></button>
                        </div>';

        // Max uses check
        if ($discountCoupon->max_uses > 0) {
            $couponUses = Order::where('coupon_code_id', $discountCoupon->id)->count();
            if ($couponUses >= $discountCoupon->max_uses) {
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon code is max usage',
                ]);
            }
        }

        // Max user check
        if ($discountCoupon->max_uses_user > 0) {
            $couponUseByUser = Order::where(['coupon_code_id' => $discountCoupon->id, 'user_id' => Auth::user()->id])->count();
            if ($couponUseByUser >= $discountCoupon->max_uses_user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon code is use by more than one user',
                ]);
            }
        }

        session()->put('code', $discountCoupon->code);
        return response()->json([
            'status' => true,
            'shipping_charge' => $shippingAmount,
            'discount' => $discount,
            'discount_format' => number_format($discount, 0, ',', '.'). ' vnđ',
            'shipping_charge_input' => number_format($shippingAmount, 0, ',', '.'),
            'shipping_charge_formatted' => number_format($shippingAmount, 0, ',', '.') . ' vnđ',
            'grand_total' => $grandTotal,
            'grand_total_formatted' => number_format($grandTotal, 0, ',', '.') . ' vnđ',
            'discountString' => $discountString,
        ]);
    }
    public function removeDiscount($province_id) {
        session()->forget('code');
        return $this->getShippingCharge($province_id);
    }
    public function processCheckout(Request $request) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'province' => 'required|numeric|min:1',
            'district' => 'required|numeric|min:1',
            'ward' => 'required|numeric|min:1',
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
        $this->saveCustomerAddress($request, $user->id);

        // Calculate discount
        $subTotal = Cart::subtotal(0, '.', '');
        list($discount, $discount_code_id, $discount_code) = $this->calculatorDiscount(session('code'), $subTotal);

        // Calculate grand total
        $shipping = $request->shipping_charge;
        $grand_total = ($subTotal - $discount) + $shipping;
        if ($request->payment_method == 'cod') {
            // Save order
            $order = $this->createOrder($request, $user->id, $subTotal, $discount, $discount_code_id, $discount_code, $shipping, $grand_total);
            // Save order items and update product quantities
            $this->saveOrderItems($order);
            // Send Order Email
            OrderEmail($order->id);

            session()->forget('code');
            Cart::destroy();
            session()->flash('success', 'Order successfully');
            return response()->json([
                'status' => true,
                'orderId' => $order->id,
                'message' => 'Order saved successfully',
            ]);
        }
        elseif ($request->payment_method == 'vnpay') {
            // Save order
            $order = $this->createOrder($request, $user->id, $subTotal, $discount, $discount_code_id, $discount_code, $shipping, $grand_total);
            // Save order items and update product quantities
            $this->saveOrderItems($order);
            $response = $this->vnpay->payment($order);
            return response()->json([
                'status' => true,
                'url' => $response['url'],
            ]);
        }
    }

    private function saveCustomerAddress($request, $userId) {
        CustomerAddress::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'province_id' => $request->province,
                'district_id' => $request->district,
                'ward_id' => $request->ward,
                'address' => $request->address,
                'phone' => $request->phone,
            ]
        );
    }

    private function calculatorDiscount($code, $subTotal) {
        $discount_code_id = null;
        $discount_code = null;
        $discount = 0;

        if ($code) {
            $coupon = DiscountCoupon::where('code', $code)->first();
            if ($coupon) {
                $discount_code_id = $coupon->id;
                $discount_code = $coupon->code;
                $discount = ($coupon->type == 'percent') ? ($coupon->discount_amount / 100) * $subTotal : $coupon->discount_amount;
            }
        }

        return [$discount, $discount_code_id, $discount_code];
    }

    private function createOrder($request, $userId, $subTotal, $discount, $discount_code_id, $discount_code, $shipping, $grand_total) {
        $order = new Order;
        $order->user_id = $userId;
        $order->subtotal = $subTotal;
        $order->shipping = $shipping;
        $order->grand_total = $grand_total;
        $order->discount = $discount;
        $order->coupon_code_id = $discount_code_id;
        $order->coupon_code = $discount_code;
        $order->payment_method = $request->payment_method;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->province_id = $request->province;
        $order->district_id = $request->district;
        $order->ward_id = $request->ward;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->note = $request->note;
        $order->save();

        return $order;
    }

    private function saveOrderItems($order) {
        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->name = $item->name;
            $orderItem->qty = $item->qty;
            $orderItem->size = $item->options->size;
            $orderItem->color = $item->options->color;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->qty;
            $orderItem->save();

            // Update product quantity
            $this->updateProductQuantity($item);
        }
    }

    private function updateProductQuantity($item) {
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
                    // Handle insufficient quantity case
                }
            }
        } else {
            // Handle size or color not found case
        }
    }


}
