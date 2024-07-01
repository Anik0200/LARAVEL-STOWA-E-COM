@extends('layouts.backend')

@section('title', 'All User')

@section('breadcamp', 'All User')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .action {
            text-align: center
        }

        .inner {
            display: inline-block;
        }

        .dataTables_filter {
            text-align: left !important;
        }
    </style>
@endsection

@section('content')

    <div class="col-md-12">

        <div class="table-data table-responsive">

            <table class="table table-striped text-center bg-white" id="posts">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>ROLE</th>
                        <th class="action">ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($allUsers) > 0)
                        @foreach ($allUsers as $allUser)
                            <tr>
                                <th>{{ $allUser->id }}</th>
                                <td>{{ $allUser->name }}</td>

                                <td>
                                    @foreach ($allUser->roles as $role)
                                        <span class="badge badge-pill badge-success">{{ $role->name }}</span>
                                    @endforeach
                                </td>

                                <td class="action">

                                    @if (!$allUser->trashed())
                                        @can('view')
                                            <a href="" class="btn btn-outline-info btn-sm">
                                                <i class="fa fa-info"></i>
                                            </a>
                                        @endcan

                                        @can('edit')
                                            <a href="{{ route('backend.user.edit', $allUser->id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete')
                                            <form class="inner" method="POST"
                                                action="{{ route('backend.user.delete', $allUser->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    @endif

                                    @if ($allUser->trashed())
                                        @can('delete')
                                            <a href="{{ route('backend.user.undo', $allUser->id) }}"
                                                class="btn btn-outline-success btn-sm">
                                                <i class="fa fa-undo"></i>
                                            </a>
                                        @endcan

                                        @can('delete')
                                            <form class="inner" action="{{ route('backend.user.destroy', $allUser->id) }}">
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
            {{ $allUsers->links() }}
        </div>
    </div>

@endsection

@section('js')
    <script script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    @if (session()->has('success'))
        <script>
            //Success Massage
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
