@extends('shipper.layouts.app')
@section('content')
    <div class="wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order: #{{ $order->id }}</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route("shipperOrder.index") }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
            <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                        <div class="card-header pt-3">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <h1 class="h5 mb-3">Shipping Address</h1>
                                    <address>
                                    <strong>{{ $order->first_name.' '.$order->last_name }}</strong><br>
                                    {{ $province}}<br>
                                    {{ $district }}<br>
                                    {{ $ward }}<br>
                                    {{ $order->address }}<br>
                                    Phone: {{ $order->phone }}<br>
                                    Email: {{ $order->email }} <br>
                                    <strong>Shipped date: </strong><br>
                                    @if (!empty($order->shipped_date))
                                        {{ \Carbon\Carbon::parse($order->shipped_date)->format('d-m-Y') }}
                                    @else
                                            n/a
                                    @endif
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #007612</b><br>
                                    <br>
                                    <b>Order ID:</b> {{ $order->id }}<br>
                                    <b>Total:</b> {{ number_format($order->grand_total, 0, ',', '.') }} vnđ<br>
                                    <b>Status:</b>
                                    @if ($order->order_status == 'pending')
                                        <span class="badge bg-warning">Peding</span>
                                    @elseif($order->order_status == 'shipped')
                                        <span class="badge bg-info">Shipped</span>
                                    @elseif ($order->order_status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                    <span class="badge bg-success">Delivery</span>
                                    @endif
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="100">Qty</th>
                                    <th width="100">Size</th>
                                    <th width="100">Color</th>
                                    <th width="100">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($orderItems as $orderItem)
                                    <tr>
                                        <td>{{ $orderItem->name }}</td>
                                        <td>{{ $orderItem->price }}</td>
                                        <td>{{ $orderItem->qty }}</td>
                                        <td>{{ $orderItem->size }}</td>
                                        <td>{{ $orderItem->color }}</td>
                                        <td>{{ $orderItem->total }}</td>
                                    </tr>
                                @endforeach
                                    <tr>
                                    <th colspan="5" class="text-right">Subtotal:</th>
                                    <td>{{ number_format($order->subtotal, 0, ',', '.') }} vnđ</td>
                                    </tr>
                                    <tr>
                                    <th colspan="5" class="text-right">Shipping:</th>
                                    <td>{{ number_format($order->shipping, 0, ',', '.') }} vnđ</td>
                                    </tr>
                                    <tr>
                                    <th colspan="5" class="text-right">Discount:</th>
                                    <td>{{ number_format($order->discount, 0, ',', '.') }} vnđ</td>
                                    </tr>
                                    <tr>
                                    <th colspan="5" class="text-right">Grand Total:</th>
                                    <td>{{ number_format($order->grand_total, 0, ',', '.') }} vnđ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                        <form action="" name="sendNotiAdmin" id="sendNotiAdmin">
                            <div class="card-body">
                            <h2 class="h4 mb-3">Send Notification to Admin</h2>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
    </div>
@endsection
@section('customJs')
<script>
    $("#sendNotiAdmin").submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: '{{ route("shipperOrder.sendMail", $order->id) }}',
            type: 'post',
            dataType: 'json',
            data: $(this).serializeArray(),
            success: function(response) {
                if (response.status == true) {
                    window.location.href = '{{ route("shipperOrder.index") }}'
                }
            }
        });
    });
</script>
@endsection

