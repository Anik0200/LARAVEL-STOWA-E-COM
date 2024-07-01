@extends('layouts.backend')

@section('title', 'Edit Roles')

@section('breadcamp', 'Edit Roles')

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
    <div class="col-md-10 fm card py-5">

        <div class="from-data">
            <form action="{{ route('backend.role.update', $id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput4">Add Roles</label>
                    <input value="{{ old('name', $role->name) }}" name="name" type="text" class="form-control rounded-0"
                        id="exampleFormControlInput4" placeholder="Role Name">

                    @error('name')
                        <div class="alert alert-danger error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput4">Select Permission: </label>
                    @foreach ($permissions as $permission)
                        <span class="ml-1">
                            <label>
                                <input name="permission[]" @if (old('permission[]', $role->permissions->contains($permission->id)) == $permission->id) checked @endif
                                    value="{{ $permission->id }}" type="checkbox">
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

@endsection
