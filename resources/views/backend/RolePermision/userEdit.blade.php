@extends('layouts.backend')

@section('title', 'Edit User')

@section('breadcamp', 'Edit User')

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
            <form method="POST" action="{{ route('backend.user.update', $id) }}">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput4">Name</label>
                    <input type="text" class="form-control rounded-0" placeholder="Enter Name" name="name"
                        value="{{ old('name', $user->name) }}">

                    @error('name')
                        <div class="alert alert-danger error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleFormControlPasswor3">Email</label>
                    <input type="email" class="form-control rounded-0" placeholder="Enter Email" name="email"
                        value="{{ old('name', $user->email) }}">

                    @error('email')
                        <div class="alert alert-danger error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="form-group">Select Roles: </label>
                    @foreach ($roles as $role)
                        <span class="ml-1">
                            <label>
                                <input name="role[]" value="{{ $role->id }}" type="checkbox"
                                    @if (old('role[]', $user->roles->contains($role->id)) == $role->id) checked @endif>
                                {{ $role->name }}
                            </label>
                        </span>
                    @endforeach

                    @error('role')
                        <div class="alert alert-danger error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-secondary btn-pill">Submit</button>
                </div>
        </div>
    </div>

@endsection
