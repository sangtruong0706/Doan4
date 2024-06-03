@extends('shipper.layouts.app')
@section('content')
    <div class="wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route("users.create") }}" class="btn btn-primary">New User</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            @include('admin.message')
            <!-- Default box -->
            <div class="container-fluid">
                @include('admin.message')
                <div class="card">
                    {{-- search form --}}
                    <form action="" method="get">
                        <div class="card-header">
                            <div class="card-title">
                                {{-- <button type="button" onclick="window.location.href='{{ route("categories.index") }}'" class="btn btn-default btn-sm">Reset</button> --}}
                                <button type="button" onclick="window.location.href=userIndexRoute" class="btn btn-default btn-sm">Reset</button>
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
                                    <th width="60">Order Id</th>
                                    <th>Custommer Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Shipped Date</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isNotEmpty())
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->first_name.' '.$order->last_name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->address.', '.$shippingAddresses[$key]['ward'].', '.$shippingAddresses[$key]['district'].', '.$shippingAddresses[$key]['province'] }}</td>
                                            <td>
                                                @if ($order->order_status == 'pending')
                                                    <span class="badge bg-danger">Peding</span>
                                                @elseif($order->order_status == 'shipped')
                                                    <span class="badge bg-info">Shipped</span>
                                                @else
                                                    <span class="badge bg-success">Delivery</span>
                                                @endif
                                            </td>
                                            <td>{{ (!empty($order->shipped_date)) ? $order->shipped_date : 'n/a' }}</td>
                                            <td>
                                                <a href="{{ route("shipperOrder.orderDetail", $order->id) }}"><i class="fas fa-shopping-bag"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Records Not Found</td>
                                    </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                    {{-- {{ $orders->links('vendor.pagination.custom_admin') }} --}}
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection



