@extends('layouts.backend')

@section('title', 'Create Roles | Permission')

@section('breadcamp', 'Create Roles | Permission')

@section('css')
    <style>
        .row {
            justify-content: center
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
        <div class="col-md-10 card py-5">

            <div class="from-data">
                <form action="{{ route('backend.permission.insert') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Add Permission</label>
                        <input name="permissionName" type="text" class="form-control rounded-0"
                            id="exampleFormControlInput4" placeholder="Permission Name">

                        @error('permissionName')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-pill">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-10 card py-5 mt-5">

            <div class="from-data">
                <form action="{{ route('backend.role.insert') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Add Roles</label>
                        <input name="name" type="text" class="form-control rounded-0" id="exampleFormControlInput4"
                            placeholder="Role Name">

                        @error('name')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Select Permission: </label>
                        @foreach ($permission as $permission)
                            <span class="ml-1">
                                <label>
                                    <input name="permission[]" value="{{ $permission->id }}" type="checkbox">
                                    {{ $permission->name }}
                                </label>
                            </span>
                        @endforeach

                        @error('permission')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-pill">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('js')
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
