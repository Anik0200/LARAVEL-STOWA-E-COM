<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('Categories:id,name')->withTrashed()->orderBy('id', 'desc')->paginate(5);

        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get(['id', 'name']);
        return view('backend.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title"             => 'required|unique:products,title',
            "sku"               => 'required|unique:products,sku',
            "price"             => 'required|integer',
            "sale_price"        => 'nullable|integer',
            "categories"        => 'required',
            "short_description" => 'nullable|max:400',
            "description"       => 'nullable|max:200',
            "add_info"          => 'nullable|max:200',
            "image"             => 'required|mimes:jpg,png,jpeg,webp',
        ]);

        $image = $request->file('image');

        if ($image) {
            $imageName = Str::uuid() . '.' . $image->extension();
            $imageUp   = Image::make($image)->crop(400, 400)->save(public_path('storage/product/' . $imageName));
        }

        if ($imageUp) {

            $product = Product::create([
                "user_id"           => auth()->user()->id,
                "title"             => $request->title,
                "sku"               => $request->sku,
                "price"             => $request->price,
                "sale_price"        => $request->sale_price,
                "short_description" => $request->short_description,
                "description"       => $request->description,
                "add_info"          => $request->add_info,
                "image"             => $imageName,
            ]);
        }

        $product->categories()->attach($request->categories);

        //Product Gallery Image Upload
        $galleryImgs = $request->file('gallery_image');

        if ($product && $galleryImgs) {

            foreach ($galleryImgs as $galleryImg) {

                $galleryImgName = Str::uuid() . '.' . $galleryImg->extension();

                Image::make($galleryImg)->crop(400, 400)->save(public_path('storage/product/' . $galleryImgName));

                ProductGallery::create([
                    'product_id' => $product->id,
                    'image'      => $galleryImgName,
                ]);
            }
        }

        return redirect(route('backend.product.index'))->with('success', 'Product Create Successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);

        return view('backend.product.show', compact('product'));
    }

    /**j
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::get(['id', 'name']);
        $product    = Product::find($id);
        return view('backend.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, $id)
    {
        $product = Product::find($id);

        $request->validate([
            "title"             => 'required',
            "sku"               => 'required',
            "price"             => 'required',
            "sale_price"        => 'nullable',
            "categories"        => 'required',
            "short_description" => 'nullable|max:400',
            "description"       => 'nullable|max:200',
            "add_info"          => 'nullable|max:200',
            "image"             => 'nullable|mimes:jpg,png,jpeg,webp',
        ]);

        $image = $request->file('image');

        if ($image) {
            $imageName = Str::uuid() . '.' . $image->extension();
            Image::make($image)->crop(400, 400)->save(public_path('storage/product/' . $imageName));

            $image_path = public_path('storage/product/' . $product->image);

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        } else {

            $imageName = $product->image;
        }

        $product->update([
            "user_id"           => auth()->user()->id,
            "title"             => $request->title,
            "sku"               => $request->sku,
            "price"             => $request->price,
            "sale_price"        => $request->sale_price,
            "short_description" => $request->short_description,
            "description"       => $request->description,
            "add_info"          => $request->add_info,
            "image"             => $imageName,
        ]);

        $product->categories()->sync($request->categories);

        return redirect(route('backend.product.index'))->with('success', 'Product Update Successfull');
    }

    /**j
     * Show the form for editing the specified resource.
     */
    public function updateGall(Request $request, $id)
    {
        $product = Product::find($id);

        $galleryImgs = $request->file('gallery_image');

        if ($product && $galleryImgs) {

            foreach ($galleryImgs as $galleryImg) {

                $galleryImgName = Str::uuid() . '.' . $galleryImg->extension();

                Image::make($galleryImg)->crop(400, 400)->save(public_path('storage/product/' . $galleryImgName));

                ProductGallery::create([
                    'product_id' => $product->id,
                    'image'      => $galleryImgName,
                ]);
                //
            }
            ////
        }

        return back()->with('success', 'Product Edit Successfull');
    }

    //Edit Gallery Image
    public function editGallImg($id)
    {
        $gallImg = ProductGallery::find($id);

        return view('backend.product.editGallImg', compact('gallImg'));
    }

    //Update Gallery Image
    public function updateGallImg(Request $request, $id)
    {
        $request->validate([
            "image" => 'required|mimes:jpg,png,jpeg,webp|max:512',
        ]);

        $gallImg = ProductGallery::find($id);

        $file = $request->file('image');

        if ($file) {

            $ImgName = Str::uuid() . '.' . $file->extension();

            Image::make($file)->crop(400, 400)->save(public_path('storage/product/' . $ImgName));

            $image_path = public_path('storage/product/' . $gallImg->image);

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        } else {

            return back()->with('success', 'Please Select Image');
        }

        $gallImg->update([
            'image' => $ImgName,
        ]);

        return redirect(route('backend.product.index'))->with('success', 'Image Update Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delteGallImg($id)
    {
        $gallImg = ProductGallery::find($id);

        $image_path = public_path('storage/product/' . $gallImg->image);
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        $gallImg->forceDelete();

        return back()->with('success', 'Image Delete Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function softDel($id)
    {
        $product = Product::find($id);

        $product->delete();

        foreach ($product->productGalleries as $productGallery) {
            $productGallery->delete();
        }

        return redirect(route('backend.product.index'))->with('success', 'Product delete Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function proUndo($id)
    {
        $product = Product::with('productGalleries')->onlyTrashed()->find($id);

        $product->restore();

        foreach ($product->productGalleries as $productGallery) {

            $productGallery->restore();
        }

        return redirect(route('backend.product.index'))->with('success', 'Product Restore Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::with('productGalleries')->onlyTrashed()->find($id);

        foreach ($product->productGalleries as $productGallery) {

            $galleryDlt = $productGallery->forceDelete();

            $productGalleryPath = public_path('storage/product/' . $productGallery->image);

            if (File::exists($productGalleryPath)) {
                File::delete($productGalleryPath);
            }
        }

        $image_path = public_path('storage/product/' . $product->image);

        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        $product->forceDelete();

        return redirect(route('backend.product.index'))->with('success', 'Product Restore Successfull');
    }
}
