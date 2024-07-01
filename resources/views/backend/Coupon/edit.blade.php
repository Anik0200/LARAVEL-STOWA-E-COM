@extends('layouts.backend')

@section('title', 'Coupon Edit')

@section('breadcamp', 'Coupon Edit')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .row {
            justify-content: center
        }

        .action {
            text-align: center
        }

        .users {
            padding-bottom: 50px,
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

        <div class="col-md-10">
            <div class="card px-5 py-2">
                <form method="POST" action="{{ route('backend.product.coupon.update', $coupon) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Name</label>
                        <input type="text" name="name" class="form-control rounded-3"
                            value="{{ old('name', $coupon->name) }}">

                        @error('name')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Amount</label>
                        <input type="number" name="amount" class="form-control rounded-3"
                            value="{{ old('amount', $coupon->amount) }}">

                        @error('amount')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Applicale Amount</label>
                        <input type="number" name="applicale_amount" class="form-control rounded-3"
                            value="{{ old('applicale_amount', $coupon->applicale_amount) }}">

                        @error('applicale_amount')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Start Date</label>
                        <input type="text" name="start_date" class="form-control rounded-3"
                            value="{{ old('start_date', $coupon->start_date) }}">

                        @error('start_date')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">End Date</label>
                        <input type="text" name="end_date" class="form-control rounded-3"
                            value="{{ old('end_date', $coupon->end_date) }}">

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
@endsection
