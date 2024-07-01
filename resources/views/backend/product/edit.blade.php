@extends('layouts.backend')

@section('title', 'Product Edit')

@section('breadcamp', 'Product Edit')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        .inner {
            display: inline-block;
        }
    </style>

@endsection

@section('content')
    {{-- Product part ---------------- --}}
    <form method="POST" enctype="multipart/form-data" action="{{ route('backend.product.update', $product->id) }}">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-md-5">
                <div class="card py-3 px-3">
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Title</label>
                        <input name="title" type="text" class="form-control rounded-3" placeholder="Title"
                            value="{{ old('title', $product->title) }}" />

                        @error('title')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">SKU</label>
                        <input name="sku" type="text" class="form-control rounded-3" placeholder="SKU"
                            value="{{ old('sku', $product->sku) }}" />

                        @error('sku')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Price</label>
                        <input name="price" type="number" class="form-control rounded-3"
                            value="{{ old('price', $product->price) }}" />

                        @error('price')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Sale Price</label>
                        <input name="sale_price" type="number" class="form-control rounded-3"
                            value="{{ old('sale_price', $product->sale_price) }}" />

                        @error('sale_price')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Categories</label>
                        @if (count($categories) > 0)
                            <select multiple name="categories[]" class="form-control rounded-3 select_2">

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif @error('categories')
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

                    <div class="mt-2">
                        <img class="img-thumbnail px-2 py-2"
                            src="{{ asset('storage/product/') . '/' . $product->image }}" alt=""
                            width="40">
                    </div>
                </div>
            </div>

            <div class="form-footer mt-2">
                <button type="submit" class="btn btn-primary col-md-12">
                    Update
                </button>
            </div>
        </div>

        <div class="col-md-5 ml-5">
            <div class="card py-3 px-3">
                <div class="form-group">
                    <label for="exampleFormControlInput4">Short Description</label>
                    <textarea class="form-control" name="short_description" rows="3" placeholder="Short Description">
                        {{ old('short_description', $product->short_description) }}
                    </textarea>

                    @error('short_description')
                        <div class="alert alert-danger error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput4">Description</label>
                    <textarea class="form-control summernote" name="description" placeholder="Description">
                        {{ $product->description }}
                    </textarea>

                    @error('description')
                        <div class="alert alert-danger error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput4">Additional Info</label>
                    <textarea class="form-control summernote" name="add_info" placeholder="Description">
                        {{ $product->add_info }}
                    </textarea>

                    @error('add_info')
                        <div class="alert alert-danger error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

</form>

{{-- gallery Image part ---------------- --}}

<div class="col-md-10">
    <div class="card mt-5 py-3 px-3">
        <form method="POST" enctype="multipart/form-data"
            action="{{ route('backend.product.updateGall', $product->id) }}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="exampleFormControlInput4">Gallery Image</label>
                <input name="gallery_image[]" type="file" class="form-control rounded-3" multiple />

                @error('gallery_image')
                    <div class="alert alert-danger error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-footer mt-2">
                <button type="submit" class="btn btn-primary col-md-12">
                    Upload More Image
                </button>
            </div>
        </form>
    </div>
</div>

<div class="col-md-10 mt-5">
    <table class="table text-center bg-white">
        <thead>
            <tr>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($product->productGalleries as $productGallry)
                <tr>
                    <td>
                        <img class="img-thumbnail px-2 py-2"
                            src="{{ asset('storage/product/') . '/' . $productGallry->image }}" alt=""
                            width="40">
                    </td>

                    <td>
                        <a href="{{ route('backend.product.editGallImg', $productGallry->id) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form class="inner" method="POST"
                            action="{{ route('backend.product.delteGallImg', $productGallry->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-dark btn-sm PermaDel">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    $(document).ready(function() {
        //Select
        $(".select_2").select2();

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
    });

    //Summer Note
    $(".summernote").summernote({
        placeholder: "Hello Bootstrap 4",
        tabsize: 2,
        height: 105,
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
