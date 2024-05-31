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
                  <li>Your Order</li>
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
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Orders #</th>
                                            <th>Date Purchased</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($orders->isNotEmpty())
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <a title="Click to see details" href="{{ route("account.orderDetails", $order->id ) }}">{{ $order->id }}</a>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @if ($order->order_status == 'pending')
                                                            <span class="badge bg-warning">Peding</span>
                                                        @elseif($order->order_status == 'shipped')
                                                            <span class="badge bg-info">Shipped</span>
                                                        @elseif ($order->order_status == 'cancelled')
                                                            <span class="badge bg-danger">Cancelled</span>
                                                        @else
                                                        <span class="badge bg-success">Delivery</span>
                                                        @endif

                                                    </td>
                                                    <td>{{ number_format($order->grand_total, 0, ',', '.') }} vnđ</td>
                                                </tr>
                                                @endforeach
                                        @else
                                                <tr>
                                                    <td colspan="3">
                                                        You haven't placed any orders yet.
                                                    </td>
                                                </tr>
                                        @endif
                                    </tbody>
                                </table>
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
