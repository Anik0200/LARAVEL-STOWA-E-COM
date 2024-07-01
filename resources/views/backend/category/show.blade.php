@extends('layouts.backend')

@section('title', $category->name)
@section('breadcamp', $category->name)

@section('css')
    <style>
        .inner {
            display: inline-block;
        }

        .td {
            text-align: center;
        }

        .image {
            display: flex;
            justify-content: center;
        }

        .img {
            padding: 5px
        }
    </style>
@endsection

@section('content')

    <div class="card card-default">

        <div class="card-body table-responsive">

            <table class="table">

                <tr>
                    <td>Name : {{ $category->name }}</td>
                </tr>

                <tr>
                    <td>Description : {{ $category->description }}</td>
                </tr>

                <tr>
                    <td>Slug : {{ $category->slug }}</td>
                </tr>

                <tr>
                    <td>Category : @foreach ($category->products as $product)
                            <span class="badge badge-pill badge-primary">{{ $product->title }}</span>
                        @endforeach
                    </td>
                </tr>

                <div>

                    <tr class="image">
                        <td>
                            <h3 class="text-center">Category Image :</h3>
                            <img class="img-thumbnail px-5 py-2"
                                src="{{ asset('storage/category/') . '/' . $category->image }}" alt="" width="400px">
                        </td>
                    </tr>
                </div>

            </table>

        </div>

    </div>

@endsection
