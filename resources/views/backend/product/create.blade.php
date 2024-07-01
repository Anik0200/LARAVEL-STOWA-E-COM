@extends('layouts.backend')

@section('title', 'Create Product')

@section('breadcamp', 'Create Product')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" />

    <style>
        .row {
            justify-content: center;
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
    <form method="POST" enctype="multipart/form-data" action="{{ route('backend.product.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <div class="card py-3 px-3">
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Title</label>
                        <input name="title" type="text" class="form-control rounded-3" placeholder="Title"
                            value="{{ old('title') }}" />

                        @error('title')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">SKU</label>
                        <input name="sku" type="text" class="form-control rounded-3" placeholder="SKU"
                            value="{{ old('sku') }}" />

                        @error('sku')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Price</label>
                        <input name="price" type="number" class="form-control rounded-3" value="{{ old('price') }}" />

                        @error('price')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Sale Price</label>
                        <input name="sale_price" type="number" class="form-control rounded-3"
                            value="{{ old('price') }}" />

                        @error('sale_price')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Categories</label>
                        @if (count($categories) > 0)
                            <select multiple name="categories[]" class="form-control rounded-3 select_2">
                                <option disabled>Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        @error('categories')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Image</label>
                        <input name="image" type="file" class="form-control rounded-3" placeholder="File"
                            value="{{ old('image') }}" />

                        @error('image')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card mt-5 py-3 px-3">
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Gallery Image</label>
                        <input name="gallery_image[]" type="file" class="form-control rounded-3" multiple
                            value="{{ old('gallery_image') }}" />

                        @error('gallery_image')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-footer mt-2">
                    <button type="submit" class="btn btn-primary col-md-12">
                        Submit
                    </button>
                </div>
            </div>

            <div class="col-md-6 ml-5">
                <div class="card py-3 px-3">
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Short Description</label>
                        <textarea class="form-control" name="short_description" rows="5" placeholder="Short Description">
                        {{ old('short_description') }}
                    </textarea>

                        @error('short_description')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Description</label>
                        <textarea class="form-control summernote" name="description" rows="8" placeholder="Description">
                        {{ old('description') }}
                    </textarea>

                        @error('description')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Additional Info</label>
                        <textarea class="form-control summernote" name="add_info" rows="8" placeholder="Description">
                        {{ old('add_info') }}
                    </textarea>

                        @error('add_info')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".select_2").select2();
        });

        //Summer Note
        $(".summernote").summernote({
            placeholder: "Hello Bootstrap 4",
            tabsize: 2,
            height: 150,
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
                ["insert", ["link", "picture"]],
            ],
        });
    </script>
@endsection
