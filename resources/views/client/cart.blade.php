@extends('client.layouts.app')
@section('content')
<div class="header_height"></div>
<div class="breadcrumb_section">
   <div class="container">
      <div class="grid">
         <div class="grid__item one-whole">
            <div class="breadcrumb_item">
               <!-- /snippets/breadcrumb.liquid -->
               <ul>
                  <li><a href="{{ route("client.home") }}" title="Back to the frontpage">Home</a></li>
                  <li>Your shopping cart</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="cart_section">
   <!-- Cart Section Start -->

   <div class="container">
      <div class="grid">
         <div class="cart_title grid__item">
            <span class="cart_page_top_icon"></span>
            <h1>Shopping Cart</h1>
         </div>
         <div class="cart_form grid__item">
            @if ($cartContent->isNotEmpty())
                <!-- Cart layout --->
                <div class="cart-layout">
                    <div class="grid">
                        <!-- Cart Header --->
                        <div class="grid__item">
                        <div class="cart-header">
                            <div class="grid__item two-twelfths small--three-twelfths medium--three-twelfths">
                                <div class="th cart-item-name">
                                    <h3>Item</h3>
                                </div>
                            </div>
                            <div class="grid__item four-twelfths small--six-twelfths medium--seven-twelfths">
                                <div class="th cart-des">
                                    <h3>description</h3>
                                </div>
                            </div>
                            <div class="grid__item two-twelfths medium--hide">
                                <div class="th cart-price">
                                    <h3>Price</h3>
                                </div>
                            </div>
                            <div class="grid__item two-twelfths medium--hide">
                                <div class="th cart-qty">
                                    <h3>Quantity</h3>
                                </div>
                            </div>
                            <div class="grid__item one-twelfth medium--two-twelfths small--two-twelfths">
                                <div class="th cart-total">
                                    <h3>Total</h3>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- Cart Item loop --->
                        <div class="grid__item cartItemWrapper">
                            @foreach ($cartContent as $item )
                                <div class="cart-items">
                                    <div class="cart-item">
                                        <div class="grid__item two-twelfths small--three-twelfths medium--three-twelfths">
                                            <div class="tr cart-item-name">
                                                <?php
                                                    $productImage = $item->options->productImages;
                                                ?>
                                                @if (!empty($productImage->image))
                                                    <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                                @else
                                                    <img src="{{ asset('admin-asset/img/default-150x150.png') }}"  >
                                                @endif
                                                {{-- <a href="">
                                                    <img src="">
                                                </a> --}}
                                            </div>
                                        </div>
                                        <div class="grid__item four-twelfths small--nine-twelfths medium--seven-twelfths">
                                            <div class="tr cart-des">
                                                <a href="/products/pre-owned-rolex-mens-submariner-stainless-steel-black-dial-watch?variant=27019909192">
                                                    {{ $item->name }}
                                                </a>
                                            <br>
                                            <small>{{ $item->options->size }} / {{ $item->options->color }}</small>
                                            <p>{{ $item->options->product_brand; }}</p>
                                            </div>
                                        </div>
                                        <div class="grid__item two-twelfths small--hide medium--hide">
                                            <div class="tr cart-price">
                                            <p><span class="money">${{ $item->price }}</span></p>
                                            </div>
                                        </div>
                                        <div class="grid__item two-twelfths small--seven-twelfths medium--three-twelfths">
                                            <div class="cart-qty">
                                            <div class="qty_box">
                                                <button type="button" class="plus"  onclick="incrementQuantity()" data-id="{{ $item->rowId }}"></button>
                                                <input type="text" name="quantity" id="quantity"  value="{{ $item->qty }}" min="0" class="product-quantity">
                                                {{-- <input type="text" value="1" readonly="readonly" name="quantity" class="product-quantity" id="quantity"> --}}
                                                <button type="button" class="minus" onclick="decrementQuantity()" data-id="{{ $item->rowId }}"></button>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="grid__item one-twelfth small--five-twelfths medium--three-twelfths">
                                            <div class="tr cart-total">
                                            <p><span class="money"> ${{ $item->price * $item->qty }}</span></p>
                                            </div>
                                        </div>
                                        <div class="tr cart-cancel">
                                            <a href="">
                                            <span><i class="fa fa-times"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <!-- Checkout section --->
                        <div class="grid__item one-whole small--one-whole medium--one-whole">
                        <div class="checkout-section grid clearfix">
                            <div class="cart_note grid__item five-twelfths small--one-whole medium--one-whole medium-down--text-left">
                                <div class="cart_review">
                                    <h3>Special instructions</h3>
                                    <textarea name="note" class="input-full" id="CartSpecialInstructions"></textarea>
                                </div>
                            </div>
                            <div class="grid__item seven-twelfths small--one-whole medium--one-whole right">
                                <h1>
                                    Sub Total :
                                    <span class="money">
                                        <p>${{ Cart::subtotal() }}</p>
                                    </span>
                                </h1>
                                <h1>
                                    Shipping :
                                    <span class="money">
                                        <p>$0</p>
                                    </span>
                                </h1>
                                <h1>
                                    Order Total :
                                    <span class="money">
                                        <p>${{ Cart::subtotal() }}</p>
                                    </span>
                                </h1>
                                <input type="" id="checkout" name="checkout" class="btn" value="Checkout">
                                <input type="" id="update-cart" name="update" style="display:none;">
                                <input type="" id="con_shopping" class="continue_shopping" value="CONTINUE SHOPPING">
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- cart empty --}}
                <div class="container">
                    <div class="grid">
                        <div class="empty_cart">
                            <p>Your cart is currently empty.</p>
                            <p><a href="{{ route("client.shop") }}"><span><i class='fa fa-angle-left'></i></span> Continue Shopping</a></p>
                        </div>
                    </div>
                </div>
            @endif



         </div>
      </div>
   </div>
</div>
@endsection
@section('customJs')
    <script>
        // function incrementQuantity() {
        //     var rowId = $(this).data('id');
        //     var quantity = parseInt($("#quantity").val());
        //     $("#quantity").val(quantity ++);
        //     var newQty = parseInt($("#quantity").val());
        //     updateCart(rowId, newQty);
        // }
        // function decrementQuantity() {
        //     var quantity = parseInt($("#quantity").val());
        //     if (quantity > 1) {
        //         $("#quantity").val(quantity --);
        //         updateCart(rowId, qty);
        //     }
        // }
        $('.add').click(function(){
            var qtyElement = $(this).parent().prev(); // Qty Input
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue+1);
            }
        });

        $('.sub').click(function(){
            var qtyElement = $(this).parent().next();
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue-1);
            }
        });
        function updateCart(rowId, qty){
            $.ajax({
                url: '{{ route("client.updateCart") }}',
                type: 'post',
                dataType: 'json',
                data: {rowId: rowId, qty: qty},
                success: function(response){

                }
            })
        }
    </script>
@endsection
