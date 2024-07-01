@extends('layouts.backend')

@section('title', 'All Orders')

@section('breadcamp', 'All Orders')

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

    <div class="users col-md-12">

        <form action="{{ route('backend.order.index') }}" method="GET">

            <span>
                <div class="float-left d-inline mb-2" style="margin-top: 10px">
                    <input type="search" placeholder="Order Id" name="order_id" class="form-control rounded-3"
                        value="{{ request()->order_id ?? '' }}">
                </div>
            </span>

            <span>
                <div class="float-left d-inline mb-2 ml-2" style="margin-top: 10px">

                    <select name="order_status" class="form-control">
                        <option value="Pending" {{ request()->order_status == 'Pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="Processing" {{ request()->order_status == 'Processing' ? 'selected' : '' }}>
                            Processing
                        </option>
                        <option value="Compleate" {{ request()->order_status == 'Compleate' ? 'selected' : '' }}>Compleate
                        </option>
                        <option value="Cancel" {{ request()->order_status == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                    </select>

                </div>
            </span>

            <span>
                <div class="float-left d-inline mb-2 ml-2" style="margin-top: 10px">

                    <select name="payment_status" class="form-control">
                        <option value="Paid" {{ request()->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Unpaid" {{ request()->payment_status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>

                </div>
            </span>

            <span>
                <div class="float-left d-inline mb-2 ml-2" style="margin-top: 10px">
                    <input type="date" name="form_date" class="form-control rounded-3"
                        value="{{ request()->form_date ?? '' }}">
                </div>
            </span>

            <span>
                <div class="float-left d-inline mb-2 ml-2" style="margin-top: 10px">
                    <input type="date" name="to_date" class="form-control rounded-3"
                        value="{{ request()->to_date ?? '' }}">
                </div>
            </span>

            <span>
                <div class="float-left d-inline mb-2 ml-2" style="margin-top: 10px">
                    <input type="submit" value="Search" class="form-control rounded-3 btn btn-sm btn-success">
                </div>
            </span>

            <span>
                <div class="float-right d-inline mb-2 ml-2" style="margin-top: 10px">
                    <a class="btn btn-outline-danger btn-sm" href="{{ route('backend.order.index') }}">
                        <i class="fa fa-undo"></i>
                    </a>
                </div>
            </span>

        </form>

        <div class="table-data table-responsive">

            <table class="table text-center bg-white" id="posts">

                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Total</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Order Date</th>
                        <th class="action">Action</th>
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

                                <td class="action">
                                    <a href="{{ route('backend.order.show', $order->id) }}"
                                        class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-info"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>

@endsection

@section('js')

    <script script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

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

    <script>
        $(document).ready(function() {

            //Sweat Alert For Delete
            $('.PermaDel').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent('form').submit();
                    }
                })
            });

            //Data Table
            // $('#posts').DataTable({
            //     "bLengthChange": false,
            //     "bPaginate": false,
            //     "bInfo": false,
            //     "ordering": false,
            // });
            //===
        });
    </script>
@endsection
