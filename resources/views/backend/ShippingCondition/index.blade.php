@extends('layouts.backend')

@section('title', 'Shipping Condition')

@section('breadcamp', 'Shipping Condition')

@section('css')
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

        .error {
            background: none;
            border: none;
            padding: 0 !important;
            margin-top: 5px;
            font-weight: bold;
        }

        .row {
            justify-content: center
        }
    </style>
@endsection

@section('content')

    <div class="row">

        <div class="users col-md-5">
            <div class="table-data table-responsive">
                <table class="table table-striped text-center bg-white ">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Location</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($shippingConditions) > 0)
                            @foreach ($shippingConditions as $shippingCondition)
                                <tr>
                                    <th>{{ $shippingCondition->id }}</th>
                                    <th>{{ $shippingCondition->location }}</th>
                                    <th>{{ $shippingCondition->shipping_amount }}</th>
                                    <td class="action d-flex">
                                        @can('edit')
                                            <a href="{{ route('backend.product.shipping.edit', $shippingCondition) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete')
                                            <form class="inner"
                                                action="{{ route('backend.product.shipping.destroy', $shippingCondition) }}">
                                                <button type="button" class="btn btn-outline-danger btn-sm PermaDel ml-2">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </form>
                                        @endcan
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $shippingConditions->links() }}
            </div>
        </div>

        <div class="col-md-5">
            <div class="card px-5 py-2">
                <form method="POST" action="{{ route('backend.product.shipping.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Location</label>
                        <input type="text" name="location" class="form-control rounded-3">

                        @error('location')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Shipping Amount</label>
                        <input type="number" name="shipping_amount" class="form-control rounded-3">

                        @error('shipping_amount')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-footer mt-2">
                        <button type="submit" class="btn btn-primary col-md-5">
                            submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        $(document).ready(function() {

            //Delete Alert
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
