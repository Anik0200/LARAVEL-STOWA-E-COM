@extends('layouts.backend')

@section('title', 'All Product')

@section('breadcamp', 'All Product')

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

            <div class="float-right d-inline" style="margin-top: 10px">

                <span><a class="btn btn-outline-primary btn-sm" href="{{ route('backend.product.create') }}">Add
                        Product</a></span>
                <span><a class="btn btn-outline-info btn-sm" href="{{ route('backend.product.color.index') }}">Product
                        Color</a></span>

            </div>

            <table class="table text-center bg-white" id="posts">

                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Sku</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Category</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/product/') . '/' . $product->image }}"
                                            alt="{{ $product->image }}" width="20">
                                    @else
                                        <img src="{{ Avatar::create('Joko Widodo')->toBase64() }}" alt=""
                                            width="20">
                                    @endif
                                </td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->slug }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->sale_price }}</td>

                                <td>
                                    @foreach ($product->Categories as $Categoy)
                                        <span class="badge badge-pill badge-primary">{{ $Categoy->name }}</span>
                                    @endforeach
                                </td>

                                <td class="action d-flex">
                                    @if (!$product->trashed())
                                        @can('view')
                                            <a href="{{ route('backend.product.inventory.index', $product->id) }}"
                                                class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-store"></i>
                                            </a>
                                        @endcan

                                        @can('view')
                                            <a href="{{ route('backend.product.show', $product->id) }}"
                                                class="btn btn-outline-info btn-sm ml-2 mr-2">
                                                <i class="fa fa-info"></i>
                                            </a>
                                        @endcan

                                        @can('edit')
                                            <a href="{{ route('backend.product.edit', $product->id) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete')
                                            <form class="inner" method="POST"
                                                action="{{ route('backend.product.softDel', $product->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-dark btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    @endif

                                    @if ($product->trashed())
                                        <a href="{{ route('backend.product.proUndo', $product->id) }}"
                                            class="btn btn-outline-warning btn-sm">
                                            <i class="fa fa-undo"></i>
                                        </a>

                                        <form class="inner" action="{{ route('backend.product.destroy', $product->id) }}">
                                            <button type="button" class="btn btn-outline-danger btn-sm PermaDel ml-2">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $products->links() }}
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
            $('#posts').DataTable({
                "bLengthChange": false,
                "bPaginate": false,
                "bInfo": false,
                "ordering": false,
            });
            //===
        });
    </script>
@endsection
