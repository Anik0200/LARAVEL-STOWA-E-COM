@extends('layouts.backend')

@section('title', 'Inventory Edit')

@section('breadcamp', 'Inventory Edit')

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
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('backend.product.inventory.update', $inventory->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" class="product_id" value="{{ $product }}">
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Size</label>
                        <select name="size" class="form-control rounded-3 select_size">
                            <option selected disabled>Select Size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" class="select_size" @selected($size->id == $inventory->size_id)>
                                    {{ $size->name }}</option>
                            @endforeach
                        </select>

                        @error('size')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Color</label>

                        <select name="color" class="form-control rounded-3 colorBox">

                            <option value="{{ $inventory->color->id }}">
                                {{ $inventory->color->name }}
                            </option>

                        </select>

                        @error('color')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Stock</label>
                        <input type="number" value="{{ old('stock', $inventory->stock) }}" name="stock"
                            class="form-control rounded-3">

                        @error('stock')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Additional Price</label>
                        <input type="number" value="{{ old('additional_price', $inventory->additional_price) }}"
                            name="additional_price" class="form-control rounded-3">

                        @error('additional_price')
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

            //Ajax
            $('.select_size').on('click', function() {

                var product_id = $('.product_id').val();
                var size_id = $('.select_size').val();

                var colorBox = $('.colorBox');
                colorBox.removeAttr('hidden');

                $.ajax({
                    type: "POST",

                    url: "{{ route('backend.product.inventory.size.select') }}",

                    data: {
                        product_id: product_id,
                        size_id: size_id,
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'JSON',

                    success: function(data) {
                        colorBox.html(data);
                    },
                });

            });

            ////======
        });
    </script>
@endsection
