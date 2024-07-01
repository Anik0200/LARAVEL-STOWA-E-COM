<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function allProduct()
    {
        $products   = Product::latest()->paginate(9);
        return view('frontend.shop', compact('products'));
    }

    public function singleProduct($slug)
    {
        $product    = Product::where('slug', $slug)->firstOrfail();

        foreach ($product->Categories as $category) {
            $relatedPros = $category->Products->take(4);
        }

        return view('frontend.singleShop', compact('product', 'relatedPros'));
    }

    public function shopColor(Request $request)
    {
        $inventories = Inventory::with('color')->where('product_id', $request->product_id)->where('size_id', $request->size_id)->get();

        $options = ['<option disabled selected data-display="All Color">Select Color</option>'];

        foreach ($inventories as $inventory) {
            $options[] = ' <option value="' . $inventory->color->id . '">' . $inventory->color->name . '</option>';
        }
        return response()->json($options);
    }

    public function shopStock(Request $request)
    {
        $inventory = Inventory::with('product')->where('product_id', $request->product_id)->where('size_id', $request->size_id)->where('color_id', $request->color_id)->first();

        if ($inventory->product->sale_price) {

            $price = $inventory->product->sale_price + $inventory->additional_price;
        } else {

            $price = $inventory->product->price + $inventory->additional_price;
        }

        $data                     = [];
        $data['additional_price'] = $inventory->additional_price;
        $data['stock']            = $inventory->stock;
        $data['price']            = $price;
        $data['inventory_id']     = $inventory->id;
        $data['producPrice']      = $inventory->product->sale_price;

        return response()->json($data);
    }
}
