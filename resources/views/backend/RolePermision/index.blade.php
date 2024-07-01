@extends('layouts.backend')

@section('title', 'All Roles')

@section('breadcamp', 'All Roles')

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
    </style>
@endsection

@section('content')

    <div class="users col-md-12">

        <div class="table-data table-responsive">

            <table class="table table-striped text-center bg-white ">

                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Permission</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($roles) > 0)
                        @foreach ($roles as $role)
                            <tr>
                                <th>{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>

                                <td>
                                    @foreach ($role->permissions as $role->permission)
                                        <span class="badge badge-pill badge-success">{{ $role->permission->name }}</span>
                                    @endforeach
                                </td>

                                <td class="action">

                                    @can('edit')
                                        <a href="{{ route('backend.role.edit', $role->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('delete')
                                        <form action="{{ route('backend.role.delete', $role->id) }}" method="POST"
                                            class="inner">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger btn-sm PermaDel">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $roles->links() }}
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
