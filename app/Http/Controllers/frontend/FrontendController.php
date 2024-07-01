<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('frontend.index', compact('products'));
    }

    public function head()
    {
        $categories = Category::with('subCategories:id,name', 'products:id,title')->limit(10)->get();
        return view('layouts.frontend', compact('categories'));

    }

    public function categoryPro($id)
    {
        $categories = Category::with('subCategories:id,name', 'products:id,title')->where('id', $id)->get();

        foreach ($categories as $cat) {
            $products = $cat->Products()->paginate(2);
        }
        return view('frontend.categoryProduct', compact('products', 'categories'));

    }

    public function productSrch(Request $request)
    {

        $categories = Category::with('subCategories:id,name', 'products:id,title')->where('id', $request->category_id)->get();

        if ($request->all()) {

            foreach ($categories as $cat) {
                $products = $cat->Products()->where('title', 'LIKE', "%" . $request->search . "%")->paginate(6);
                return view('frontend.searchProduct', compact('products', 'categories'));
            }

            if ($request->search) {
                $products = Product::where('title', 'LIKE', "%" . $request->search . "%")->paginate(6);
                return view('frontend.searchProduct', compact('products', 'categories'));
            }

        } elseif (!$request->search) {

            foreach ($categories as $cat) {
                $products = $cat->Products()->paginate(6);
                return view('frontend.searchProduct', compact('products', 'categories'));
            }

        }

    }

}
