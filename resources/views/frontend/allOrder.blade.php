@extends('layouts.frontend')

@section('title', 'All Orders')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .action {
            text-align: center
        }

        .users {
            padding-bottom: 50px,
        }

        .inner {
            display: inline-block;
        }

        .childSub {
            background-color: #E6E6E6;
        }

        .dataTables_filter {
            text-align: left !important;
            display: inline;
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                <li>All Orders</li>
            </ul>
        </div>
    </div>

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8 display">
                <table class="table table-responsive text-center bg-white" id="posts">

                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Total</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            <th>Order Date</th>
                            {{-- <th class="action">Action</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($orders) > 0)
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->order_status }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>{{ $order->created_at->isoFormat('DD MMM YYYY') }}</td>

                                    {{-- <td class="action">
                                        <a href="{{ route('user.orders.invoice', $order->invoice->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-info"></i>
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>

    </div>


@endsection

@section('js')

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<p class="fs-5">{{ Session::get('success') }}</p>',
                showConfirmButton: false,
                timer: 1500,
            })
        </script>
    @endif

@endsection
