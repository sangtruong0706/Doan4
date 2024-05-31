<?php

use App\Models\Order;
use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Mail;

    function getCategories() {
        return Category::orderBy('name', 'ASC')->where('showHome', 'Yes')->get();
    }

    function getProductImages ($product_id) {
        return ProductImage::where('product_id', $product_id)->first();
    }

    function OrderEmail($order_id) {
        $order = Order::where('id', $order_id)->with('items', 'province', 'district', 'ward')->first();

        $mailData = [
            'subject' => 'Thank for your order',
            'order' => $order
        ];

        Mail::to($order->email)->send(new OrderEmail($mailData));
        // dd($order);
    }

?>
