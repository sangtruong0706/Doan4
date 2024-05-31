@extends('admin.layouts.app')
@section('content')
<div class="wrapper">
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-title">
                            {{-- <button type="button" onclick="window.location.href='{{ route("categories.index") }}'" class="btn btn-default btn-sm">Reset</button> --}}
                            <button type="button" onclick="window.location.href=orderIndexRoute" class="btn btn-default btn-sm">Reset</button>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Orders #</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date Purchased</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->isNotEmpty())
                                @foreach ($orders as $order)
                                    <tr>
                                        <td><a title="Click to see detail" href="{{ route("orders.detail", $order->id) }}">{{ $order->id }}</a></td>
                                        <td>{{ $order->user_name }}</td>
                                        <td>{{ $order->user_email }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>
                                            @if ($order->order_status == 'pending')
                                                <span class="badge bg-danger">Peding</span>
                                            @elseif($order->order_status == 'shipped')
                                                <span class="badge bg-info">Shipped</span>
                                            @else
                                                <span class="badge bg-success">Delivery</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->grand_total, 0, ',', '.') }} vnđ</td>
                                        <td> {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">
                                        Recods not found
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                {{ $orders->links('vendor.pagination.custom_admin') }}
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('customJs')
<script>
    var orderIndexRoute = "{{ route('orders.index') }}";
</script>
@endsection
