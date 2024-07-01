@extends('layouts.backend')

@section('title', 'All Orders')

@section('breadcamp', 'Order id : ' . $order->id)

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
        <div class="table-data table-responsive">
            <table class="table text-center bg-white">

                <tr>
                    <td class="float-left">
                        Customer Name : {{ $order->user->name }}
                    </td>
                </tr>

                <tr>
                    <td class="float-left">
                        Products : @foreach ($inventoryOrders as $inventoryOrder)
                            <span class="badge badge-pill badge-primary">
                                {{ $inventoryOrder->inventory->product->title }}
                            </span>
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td class="float-left">

                        Order Status : <form action="{{ route('backend.order.update', $order->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <select name="order_status" class="form-control">
                                <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Processing" {{ $order->order_status == 'Processing' ? 'selected' : '' }}>
                                    Processing
                                </option>
                                <option value="Compleate" {{ $order->order_status == 'Compleate' ? 'selected' : '' }}>
                                    Compleate
                                </option>
                                <option value="Cancel" {{ $order->order_status == 'Cancel' ? 'selected' : '' }}>Cancel
                                </option>
                            </select>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-sm btn-primary">UPDATE</button>
                            </div>
                        </form>
                    </td>
                </tr>

            </table>
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

        });
    </script>
@endsection
