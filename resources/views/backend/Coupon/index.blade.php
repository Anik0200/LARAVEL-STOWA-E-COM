@extends('layouts.backend')

@section('title', 'Product Coupon')

@section('breadcamp', 'Coupon')

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
    </style>
@endsection

@section('content')

    <div class="row">

        <div class="users col-md-8">
            <div class="table-data table-responsive">
                <table class="table table-striped text-center bg-white ">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Aplicable Amount</th>
                            <th>Strat Date</th>
                            <th>End Date</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($coupons) > 0)
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <th>{{ $coupon->id }}</th>
                                    <th>{{ $coupon->name }}</th>
                                    <th>{{ $coupon->amount }}</th>
                                    <th>{{ $coupon->applicale_amount }}</th>
                                    <th>{{ $coupon->start_date->isoFormat('d MMM YYYY') }}</th>
                                    <th>{{ $coupon->end_date->isoFormat('d MMM YYYY') }}</th>
                                    <td class="action">
                                        @can('edit')
                                            <a href="{{ route('backend.product.coupon.edit', $coupon) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete')
                                            <form class="inner" action="{{ route('backend.product.coupon.destroy', $coupon) }}">
                                                <button type="button" class="btn btn-outline-danger btn-sm PermaDel">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </form>
                                        @endcan
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $coupons->links() }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="card px-5 py-2">
                <form method="POST" action="{{ route('backend.product.coupon.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Name</label>
                        <input type="text" name="name" class="form-control rounded-3">

                        @error('name')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Amount</label>
                        <input type="number" name="amount" class="form-control rounded-3">

                        @error('amount')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Applicale Amount</label>
                        <input type="number" name="applicale_amount" class="form-control rounded-3">

                        @error('applicale_amount')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Start Date</label>
                        <input type="date" name="start_date" class="form-control rounded-3">

                        @error('start_date')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">End Date</label>
                        <input type="date" name="end_date" class="form-control rounded-3">

                        @error('end_date')
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
