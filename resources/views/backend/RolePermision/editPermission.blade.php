@extends('layouts.backend')

@section('title', 'Edit Permission')

@section('breadcamp', 'Edit Permission')

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
                <form action="{{ route('backend.permission.update', $id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Permission</label>
                        <input name="name" type="text" class="form-control rounded-0" placeholder="Permission Name"
                            value="{{ old('name', $permission->name) }}">

                        @error('name')
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
