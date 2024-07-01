@extends('layouts.backend')

@section('title', 'Edit Gallery Image')

@section('breadcamp', 'Edit Gallery Image')

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
        <div class="col-md-10">
            <div class="card px-5 py-2">
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('backend.product.updateGallImg', $gallImg->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Image</label>
                        <input name="image" type="file" class="form-control rounded-3" />

                        @error('image')
                            <div class="alert alert-danger error">{{ $message }}</div>
                        @enderror

                        <div class="mt-2">
                            <img class="img-thumbnail px-2 py-2"
                                src="{{ asset('storage/product/') . '/' . $gallImg->image }}" alt="" width="40">
                        </div>
                    </div>

                    <div class="form-footer mt-2">
                        <button type="submit" class="btn btn-primary col-md-12">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('js')

@endsection
