@extends('layouts.backend')

@section('title', 'Product Inventory')

@section('breadcamp', $product->title)

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

        <div class="users col-md-6">
            <div class="table-data table-responsive">
                <table class="table table-striped text-center bg-white ">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Stock</th>
                            <th>Add Price</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($inventories) > 0)
                            @foreach ($inventories as $inventory)
                                <tr>
                                    <th>{{ $inventory->id }}</th>
                                    <th>{{ $inventory->size->name }}</th>
                                    <th>{{ $inventory->color->name }}</th>
                                    <td>{{ $inventory->stock }}</td>
                                    <td>{{ $inventory->additional_price }}</td>

                                    <td class="action">

                                        @can('edit')
                                            <a href="{{ route('backend.product.inventory.edit', $inventory->id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete')
                                            <form class="inner"
                                                action="{{ route('backend.product.inventory.destroy', $inventory->id) }}">
                                                <button type="button" class="btn btn-outline-danger btn-sm PermaDel">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $inventories->links() }}
            </div>
        </div>

        <div class="col-md-5">
            <div class="card px-5 py-2">
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('backend.product.inventory.store', $product->id) }}">
                    @csrf
                    <input type="hidden" value="{{ $product->id }}" class="productId">
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Size</label>
                        <select name="size" class="form-control rounded-3 select_size">
                            <option selected disabled>Select Size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" class="select_size">{{ $size->name }}</option>
                            @endforeach
                        </select>

                        @error('size')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Color</label>

                        <select disabled name="color" class="form-control rounded-3 colorBox">
                            <option disabled selected>Select</option>


                        </select>

                        @error('color')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Stock</label>
                        <input type="number" name="stock" class="form-control rounded-3">

                        @error('stock')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Additional Price</label>
                        <input type="number" name="additional_price" class="form-control rounded-3">

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

            //Ajax
            $('.select_size').on('change', function() {

                var product_id = $('.productId').val();
                var size_id = $('.select_size').val();

                var colorBox = $('.colorBox');
                colorBox.removeAttr('disabled');

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
