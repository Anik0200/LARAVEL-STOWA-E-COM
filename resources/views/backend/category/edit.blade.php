@extends('layouts.backend')

@section('title', 'Edit CAtegory | ' . $category->name)

@section('breadcamp', 'Edit CAtegory | ' . $category->name)

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
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('backend.product.category.update', $id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="exampleFormControlInput4">Name</label>
                        <input name="name" type="text" class="form-control rounded-3" placeholder="Category Name"
                            value="{{ old('name', $category->name) }}">

                        @error('name')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="exampleFormControlInput4">Description</label>
                        <textarea name="description" type="text" rows="5" class="form-control rounded-3" placeholder="Description">{{ $category->description }}
                        </textarea>

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
                        <div class="mt-2">
                            <img class="img-thumbnail" src="{{ asset('storage/category/') . '/' . $category->image }}"
                                alt="" width="40">
                        </div>
                    </div>

                    <input type="text" name="old_image" hidden value="{{ $category->image }}">

                    <div class="form-group">
                        <label>Prent</label>
                        <select name="parent_id" class="form-control rounded-3 select_2">
                            <option selected disabled>Select</option>
                            @foreach ($categories as $category)
                                <option @selected(old('parent_id', $category->subCategories->contains($id)) == $category->id) value="{{ $category->id }}"> {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
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
            //Select2
            $('.select_2').select2();
        });
    </script>
@endsection
