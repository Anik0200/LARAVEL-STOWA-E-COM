@extends('layouts.backend')

@section('title', $product->title)
@section('breadcamp', $product->title)

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

    <div class="col-md-12 card card-default">

        <div class="card-body table-responsive">

            <table class="table">

                <tr>
                    <td>Title : {{ $product->title }}</td>
                </tr>

                <tr>
                    <td>Creator : {{ $product->User->name }}</td>
                </tr>

                <tr>
                    <td>Slug : {{ $product->slug }}</td>
                </tr>

                <tr>
                    <td>Sku : {{ $product->sku }}</td>
                </tr>

                <tr>
                    <td>Description : {{ $product->description }}</td>
                </tr>

                <tr>
                    <td>Short Description : {{ $product->short_description }}</td>
                </tr>

                <tr>
                    <td>Additional Info : {{ $product->add_info }}</td>
                </tr>

                <tr>
                    <td>Category : @foreach ($product->Categories as $Categoy)
                            <span class="badge badge-pill badge-primary">{{ $Categoy->name }}</span>
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td>Price : {{ $product->price }}</td>
                </tr>

                <tr>
                    <td>Sale Price : {{ $product->sale_price }}</td>
                </tr>

                <div>
                    <tr class="image">
                        <td>
                            <h3 class="text-center">Category Image :</h3>
                            <img class="img-thumbnail px-2 py-2"
                                src="{{ asset('storage/product/') . '/' . $product->image }}" alt="" width="200">

                            @foreach ($product->productGalleries as $productGallry)
                                <span>
                                    <img class="img-thumbnail px-2 py-2"
                                        src="{{ asset('storage/product/') . '/' . $productGallry->image }}" alt=""
                                        width="200">
                                </span>
                            @endforeach

                        </td>
                    </tr>
                </div>

            </table>

        </div>

    </div>

@endsection
