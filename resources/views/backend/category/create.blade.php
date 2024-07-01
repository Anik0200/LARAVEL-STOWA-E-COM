@extends('layouts.backend')

@section('title', 'Create Category')

@section('breadcamp', 'Create Category')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
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
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.product.category.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Name</label>
                        <input name="name" type="text" class="form-control rounded-3" placeholder="Category Name"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Prent</label>
                        @if (count($categories) > 0)
                            <select name="parent_id" class="form-control rounded-3 select_2">
                                <option selected disabled>Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Description</label>
                        <textarea name="description" type="text" rows="5" class="form-control rounded-3" placeholder="Description">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Image</label>
                        <input name="image" type="file" class="form-control rounded-3" placeholder="File"
                            value="{{ old('image') }}">

                        @error('image')
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select_2').select2();
        });
    </script>
@endsection
