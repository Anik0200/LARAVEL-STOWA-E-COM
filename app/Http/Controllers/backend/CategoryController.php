<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Foundation\Events\PublishingStubs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['subCategories' => function ($p) {

            $p->with('products:id,title');
        }], 'products:id,title')

            ->where('parent_id', null)
            ->withTrashed()
            ->paginate(5);

        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('parent_id', null)
            ->get(['id', 'name']);
        return view('backend.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'name'        => 'required|max:200',
                'parent'      => 'nullable|integer',
                'description' => 'nullable|max:400',
                'file'        => 'nullable|mimes:png,jpg,jpeg,|max:500',
            ],
            [
                'name.required'   => 'This Field Is Required',
                'name.max'        => 'Max 200 Word',
                'parent.parent'   => 'Parent Must Integer',
                'description.max' => 'Max 400 Word',
                'file.mimes'      => 'Please Select Valid File',
                'file.max'        => 'Max File Size 500kb',
            ]
        );

        $file      = $request->image;
        $imageName = null;

        if ($file) {

            $imageName = time() . '.' . $file->getClientOriginalName();
            // Image::make($file)->crop(200, 200)->save(public_path('storage/category/' . $imageName));
            $file->move(public_path('storage/category'), $imageName);
        }

        Category::create([
            'parent_id'   => $request->parent_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'image'       => $imageName,
        ]);

        return redirect(route('backend.product.category.index'))->with('success', 'Create Success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::with('products:id,title')->find($id);
        return view('backend.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category   = Category::find($id);
        $categories = Category::where('parent_id', null)
            ->get(['id', 'name', 'parent_id']);

        return view('backend.category.edit', compact('categories', 'id', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name'        => 'required',
                'parent'      => 'nullable|integer',
                'description' => 'nullable|max:400',
                'file'        => 'nullable|mimes:png,jpg,jpeg,|max:500',
            ],
            [
                'name.required'   => 'This Field Is Required',
                'name.max'        => 'Max 200 Word',
                'parent.parent'   => 'Parent Must Integer',
                'description.max' => 'Max 400 Word',
                'file.mimes'      => 'Please Select Valid File',
                'file.max'        => 'Max File Size 500kb',
            ]
        );

        $category = Category::find($id);

        $file      = $request->image;
        $imageName = $category->image;

        if ($file) {

            $imageName = time() . '_' . $file->getClientOriginalName();
            // Image::make($file)->crop(200, 200)->save(public_path('storage/category/' . $imageName));
            $file->move(public_path('storage/category'), $imageName);
        }

        if ($file) {

            $image_path = public_path('storage/category/' . $category->image);

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $category->update([
            'parent_id'   => $request->parent_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'image'       => $imageName,
        ]);

        return redirect(route('backend.product.category.index'))->with('success', 'Edit Success');
    }

    /**
     * Delete the specified resource from storage.
     */
    public function delete($id)
    {
        $category = Category::find($id);

        $category->delete();
        return redirect(route('backend.product.category.index'))->with('success', 'You Can Retrive');
    }

    /**
     * Undo the specified resource from storage.
     */
    public function categoryUndo($id)
    {
        $category = Category::onlyTrashed()->find($id);

        $category->update([
            'deleted_at' => null,
        ]);

        return redirect(route('backend.product.category.index'))->with('success', 'Retrive Success');
    }

    /**
     * Destroy the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::onlyTrashed()->find($id);

        $image_path = public_path('storage/category/' . $category->image);

        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        $category->forceDelete();

        return redirect(route('backend.product.category.index'))->with('success', 'Delete Success');
    }
}
