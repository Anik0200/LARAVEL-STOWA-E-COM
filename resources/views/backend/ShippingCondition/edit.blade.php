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

        .row {
            justify-content: center
        }
    </style>
@endsection

@section('content')

    <div class="row">

        <div class="col-md-10">
            <div class="card px-5 py-2">
                <form method="POST" action="{{ route('backend.product.shipping.update', $shippingCondition) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Location</label>
                        <input type="text" name="location" class="form-control rounded-3"
                            value="{{ old('location', $shippingCondition->location) }}">

                        @error('location')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Shipping Amount</label>
                        <input type="number" name="shipping_amount" class="form-control rounded-3"
                            value="{{ old('location', $shippingCondition->shipping_amount) }}">

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
@endsection
