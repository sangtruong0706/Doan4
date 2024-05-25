<?php
namespace App\Http\Composers;

use Illuminate\View\View;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartComposer
{
    public function compose(View $view)
    {
        $view->with('cartContent', Cart::content());
        $view->with('cartTotal', Cart::total());
        $view->with('cartSubTotal', Cart::subtotal());
        $view->with('cartCount', Cart::count());
        $countCart =0;
        foreach (Cart::content() as $item) {
            $countCart++;
        }
        $view->with('countCart', $countCart);
    }
}
