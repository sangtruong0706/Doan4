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
                  <li><a href="{{ route("account.profile") }}" title="Back to the frontpage">Profile</a></li>
                  <li>Order Details</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="content">
    <div id="customer-account">
        <section class=" section-11 ">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        @include('client.account.sidebar')
                    </div>
                    <div class="col-md-9">
                        <h1>My Order</h1>
                        <div class="card-body p-3">
                            <div class="card-body pb-0">
                                <!-- Info -->
                                <div class="card card-sm">
                                    <div class="card-body bg-light mb-3">
                                        <div class="row">
                                            <div class="col-6 col-lg-3">
                                                <!-- Heading -->
                                                <h6 class="heading-xxxs text-muted">Order No: </h6>
                                                <!-- Text -->
                                                <p class="mb-lg-0 fs-sm fw-bold">
                                                {{ $order->id }}
                                                </p>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <!-- Heading -->
                                                <h6 class="heading-xxxs text-muted">Shipped date:</h6>
                                                <!-- Text -->
                                                <p class="mb-lg-0 fs-sm fw-bold">
                                                    <time datetime="2019-10-01">
                                                        @if (!empty($order->shipped_date))
                                                            {{ \Carbon\Carbon::parse($order->shipped_date)->format('d-m-Y') }}
                                                        @else
                                                            n/a
                                                        @endif
                                                    </time>
                                                </p>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <!-- Heading -->
                                                <h6 class="heading-xxxs text-muted">Status:</h6>
                                                <!-- Text -->
                                                <p class="mb-0 fs-sm fw-bold">
                                                    @if ($order->order_status == 'pending')
                                                        <span class="badge bg-warning">Peding</span>
                                                    @elseif($order->order_status == 'shipped')
                                                        <span class="badge bg-info">Shipped</span>
                                                    @elseif ($order->order_status == 'cancelled')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @else
                                                    <span class="badge bg-success">Delivery</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <!-- Heading -->
                                                <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                                <!-- Text -->
                                                <p class="mb-0 fs-sm fw-bold">
                                                    {{ number_format($order->grand_total, 0, ',', '.') }} vnđ
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-3">
                                <!-- Heading -->
                                <h6 class="mb-7 h5 mt-4">Order Items ({{ $orderItems->count() }})</h6>
                                <!-- Divider -->
                                <hr class="my-3">
                                <!-- List group -->
                                <ul>
                                    @foreach ($orderItems as $orderItem)
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-4 col-md-3 col-xl-2">
                                                    <!-- Image -->
                                                    @php
                                                        $productImages = getProductImages($orderItem->product_id);
                                                    @endphp
                                                    {{-- <a href="product.html"><img src="images/product-1.jpg" alt="..." class="img-fluid"></a> --}}
                                                    @if (!empty($productImages->image))
                                                        <img class="img-fluid" src="{{ asset('uploads/product/small/'.$productImages->image) }}" >
                                                    @else
                                                        <img class="img-fluid" src="{{ asset('admin-asset/img/default-150x150.png') }}"  >
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <!-- Title -->
                                                    <p class="mb-4 fs-sm fw-bold">
                                                        <a class="text-body" href="{{ route("client.product", $orderItem->product_id) }}">{{ $orderItem->name }} x {{ $orderItem->qty }}</a> <br>
                                                        <span class="text-muted">{{ $orderItem->size }} / {{ $orderItem->color }}</span> <br>
                                                        <span class="text-muted">{{ number_format($orderItem->price, 0, ',', '.') }} vnđ</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card card-lg mb-5 mt-3">
                            <div class="card-body">
                                <!-- Heading -->
                                <h6 class="mt-0 mb-3 h5">Order Total</h6>

                                <!-- List group -->
                                <ul>
                                    <li class="list-group-item d-flex">
                                        <span>Subtotal</span>
                                        <span class="ms-auto">{{ number_format($order->subtotal, 0, ',', '.') }} vnđ</span>
                                    </li>
                                    <li class="list-group-item d-flex">
                                        <span>Shipping</span>
                                        <span class="ms-auto">{{ number_format($order->shipping, 0, ',', '.') }} vnđ</span>
                                    </li>
                                    @if (!empty($order->coupon_code))
                                    <li class="list-group-item d-flex">
                                        <span>Coupon code used</span>
                                        <span class="ms-auto">{{ $order->coupon_code }}</span>
                                    </li>
                                    @endif
                                    <li class="list-group-item d-flex">
                                        <span>Discount</span>
                                        <span class="ms-auto">{{ number_format($order->discount, 0, ',', '.') }} vnđ</span>
                                    </li>
                                    <li class="list-group-item d-flex fs-lg fw-bold">
                                        <span>Total</span>
                                        <span class="ms-auto">{{ number_format($order->grand_total, 0, ',', '.') }} vnđ</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
@section('customJs')
    <script>

    </script>
@endsection
