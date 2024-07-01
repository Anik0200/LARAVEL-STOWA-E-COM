@extends('layouts.backend')

@section('title', 'Product Color')

@section('breadcamp', 'Product Color')

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
                            <th>Name</th>
                            <th>Slug</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($colors) > 0)
                            @foreach ($colors as $color)
                                <tr>
                                    <th>{{ $color->id }}</th>
                                    <td>{{ $color->name }}</td>
                                    <td>{{ $color->slug }}</td>

                                    <td class="action">
                                        @if (!$color->trashed())
                                            @can('edit')
                                                <a href="{{ route('backend.product.color.edit', $color->id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('delete')
                                                <form class="inner" method="POST"
                                                    action="{{ route('backend.product.color.softDel', $color->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif

                                        @if ($color->trashed())
                                            @can('delete')
                                                <a href="{{ route('backend.product.color.Undo', $color->id) }}"
                                                    class="btn btn-outline-success btn-sm">
                                                    <i class="fa fa-undo"></i>
                                                </a>
                                            @endcan

                                            @can('delete')
                                                <form class="inner"
                                                    action="{{ route('backend.product.color.destroy', $color->id) }}">
                                                    <button type="button" class="btn btn-outline-danger btn-sm PermaDel">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $colors->links() }}
            </div>
        </div>

        <div class="col-md-5">

            <div class="card px-5 py-2">
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.product.color.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Color</label>
                        <input name="name" type="text" class="form-control rounded-3" />

                        @error('name')
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
