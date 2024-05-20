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
                                <div id="row_{{ $item->id }}" class="cart-items">
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
                                                <div>
                                                    <button type="button" class="plus add"   data-id="{{ $item->rowId }}"></button>
                                                </div>
                                                <input type="text"  value="{{ $item->qty }}" >
                                                <div>
                                                    <button type="button" class="minus sub"  data-id="{{ $item->rowId }}"></button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="grid__item one-twelfth small--five-twelfths medium--three-twelfths">
                                            <div class="tr cart-total">
                                            <p><span id="cartTotal_{{ $item->id }}" class="money"> ${{ $item->price * $item->qty }}</span></p>
                                            </div>
                                        </div>
                                        <div class="tr cart-cancel">
                                            <button  onclick="deleteItem('{{ $item->rowId }}')">
                                            <span><i class="fa fa-times"></i></span>
                                            </button>
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
                                    @php
                                    $subtotal = 0;
                                    $shippingCost = 20;
                                    $orderTotal = 0;
                                    @endphp
                                    @foreach(Cart::content() as $item)
                                        @php
                                            $total = $item->price * $item->qty;
                                            $subtotal += $total;
                                        @endphp
                                    @endforeach

                                    <h1>
                                        Sub Total :
                                        <span>
                                            <p id="cart_subTotal">${{ $subtotal }}</p>
                                        </span>
                                    </h1>
                                    <h1>
                                        Shipping :
                                        <span >
                                            <p>$20</p>
                                        </span>
                                    </h1>
                                    <h1>
                                        @php
                                            $orderTotal = $subtotal +20;
                                        @endphp
                                        Order Total :
                                        <span>
                                            <p id="order-total">${{ $orderTotal }}</p>
                                        </span>
                                    </h1>
                                    <div class="row" style="display: flex; justify-content: right; align-items: center;">
                                        <div class="col-md-6">
                                            <input onclick="Continue_shopping()" type="button" id="checkout" name="checkout" class="continue_shopping" value="CONTINUE SHOPPING">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="button" id="checkout" name="checkout" class="check_btn" value="Checkout">
                                        </div>

                                           {{-- <a href="{{ route("client.shop") }}" class="btn continue_shopping">CONTINUE SHOPPING</a> --}}





                                    </div>
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

        $('.add').click(function(){
            var qtyElement = $(this).parent().next('input'); // Qty Input
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue+1);
                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateCart(rowId, newQty)
            }
        });

        $('.sub').click(function(){
            var qtyElement = $(this).parent().prev('input');
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue-1);
                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateCart(rowId, newQty)
            }
        });

        function updateCart(rowId, qty){
            var shippingCost = 20;
            $.ajax({
                url: '{{ route("client.updateCart") }}',
                type: 'post',
                dataType: 'json',
                data: {rowId: rowId, qty: qty},
                success: function(response){
                    if (response.status == true) {
                        var subtotal = parseFloat(response.data.subtotal);
                        var orderTotal = subtotal + shippingCost;
                        $('#cart_subTotal').text('$' + response.data.subtotal);
                        response.data.cart_items.forEach(function(item) {
                            $('#cartTotal_' + item.product_id).text('$' + item.total);
                        });
                        $('#order-total').text('$' + orderTotal);

                    }
                }
            })
        }
        function deleteItem(rowId){
            $.ajax({
                url: '{{ route("client.deleteItem") }}',
                type: 'post',
                dataType: 'json',
                data: {rowId: rowId},
                success: function(response){
                    if (response.status == true) {
                        $('#row_' + response.data.product_id).hide();
                        $('#cart_subTotal').text('$' + response.data.subtotal);
                        $('#order-total').text('$' + response.data.ordertotal);
                    }
                }
            })
        }

        function Continue_shopping(){
            location.href = '{{ route("client.shop") }}';
        }
        // function formatCurrency(value) {
        //     return parseFloat(value).toLocaleString('en-US', {
        //         minimumFractionDigits: 0,
        //         maximumFractionDigits: 2
        //     }).replace(/\.00$/, '');
        // }
    </script>
@endsection
