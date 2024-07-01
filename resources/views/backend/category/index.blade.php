@extends('layouts.backend')

@section('title', 'All Category')

@section('breadcamp', 'All Category')

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
        }
    </style>
@endsection

@section('content')

    <div class="users col-md-12">

        <div class="table-data table-responsive">

            <table class="table text-center bg-white" id="posts">

                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Product Count</th>
                        <th>Status</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($categories) > 0)
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    @if ($category->image)
                                        <img src="{{ asset('storage/category/') . '/' . $category->image }}" alt=""
                                            width="20">
                                    @else
                                        <img src="{{ Avatar::create('Joko Widodo')->toBase64() }}" alt=""
                                            width="20">
                                    @endif
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ count($category->products) }}</td>
                                <td>{{ $category->status }}</td>

                                <td class="action d-flex">

                                    @if (!$category->trashed())
                                        @can('view')
                                            <a href="{{ route('backend.product.category.show', $category->id) }}"
                                                class="btn btn-outline-info btn-sm">
                                                <i class="fa fa-info"></i>
                                            </a>
                                        @endcan

                                        @can('edit')
                                            <a href="{{ route('backend.product.category.edit', $category->id) }}"
                                                class="btn btn-outline-primary btn-sm ml-2 mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete')
                                            <form class="inner" method="POST"
                                                action="{{ route('backend.product.category.delete', $category->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-dark btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    @endif

                                    @if ($category->trashed())
                                        <a href="{{ route('backend.product.category.categoryUndo', $category->id) }}"
                                            class="btn btn-outline-warning btn-sm">
                                            <i class="fa fa-undo"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>

                            @if ($category->subCategories)
                                @foreach ($category->subCategories as $subCategoy)
                                    <tr style="background-color: #E6E6E6">
                                        <td>--</td>
                                        <td>
                                            @if ($subCategoy->image)
                                                <img src="{{ asset('storage/category/') . '/' . $subCategoy->image }}"
                                                    alt="" width="20">
                                            @else
                                                <img src="{{ Avatar::create('Joko Widodo')->toBase64() }}" alt=""
                                                    width="20">
                                            @endif
                                        </td>
                                        <td>{{ $subCategoy->name }}</td>
                                        <td>{{ $subCategoy->slug }}</td>
                                        <td>{{ count($subCategoy->products) }}</td>
                                        <td>{{ $subCategoy->status }}</td>

                                        <td class="action d-flex">

                                            @if (!$subCategoy->trashed())
                                                @can('view')
                                                    <a href="{{ route('backend.product.category.show', $subCategoy->id) }}"
                                                        class="btn btn-outline-info btn-sm">
                                                        <i class="fa fa-info"></i>
                                                    </a>
                                                @endcan

                                                @can('edit')
                                                    <a href="{{ route('backend.product.category.edit', $subCategoy->id) }}"
                                                        class="btn btn-outline-primary btn-sm ml-2 mr-2">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan

                                                @can('delete')
                                                    <form class="inner" method="POST"
                                                        action="{{ route('backend.product.category.delete', $subCategoy->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-dark btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif

                                            @if ($subCategoy->trashed())
                                                <a href="{{ route('backend.product.category.categoryUndo', $subCategoy->id) }}"
                                                    class="btn btn-outline-warning btn-sm">
                                                    <i class="fa fa-undo"></i>
                                                </a>

                                                <form class="inner"
                                                    action="{{ route('backend.product.category.destroy', $subCategoy->id) }}">
                                                    <button type="button" class="btn btn-outline-danger btn-sm PermaDel">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $categories->links() }}
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
