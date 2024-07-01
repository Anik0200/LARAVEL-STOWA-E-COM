<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $product = Product::find($id);
        $sizes   = Size::all();

        $inventories = Inventory::with('size:id,name')->where('product_id', $id)->paginate(5);

        return view('backend.inventory.index', compact('product', 'sizes', 'inventories'));
    }

    public function sizeSelect(Request $request)
    {
        $inventories = Inventory::where('product_id', $request->product_id)
            ->where('size_id', $request->size_id)
            ->get();

        $colors_id = $inventories->pluck('color_id')->toArray();

        $colors = Color::whereNotIn('id', $colors_id)->get();

        $options = [];
        foreach ($colors as $color) {
            $options[] = "<option value='" . $color->id . "'>" . $color->name . "</option>";
        }

        return response()->json($options);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'color'            => 'required',
            'size'             => 'required',
            'stock'            => 'required',
            'additional_price' => 'nullable|numeric',
        ]);

        Inventory::create([
            'product_id'       => $id,
            'color_id'         => $request->color,
            'size_id'          => $request->size,
            'stock'            => $request->stock,
            'additional_price' => $request->additional_price,
        ]);

        return back()->with('success', 'Inventory Created');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory, $id)
    {
        $inventory = Inventory::find($id);

        $product = $inventory->product->id;

        $sizes = Size::all();

        return view('backend.inventory.edit', compact('inventory', 'sizes', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'color'            => 'required',
            'size'             => 'required',
            'stock'            => 'required',
            'additional_price' => 'nullable|numeric',
        ]);

        $inventory = Inventory::find($id);

        $product_id = $inventory->product->id;

        $inventory->update([
            'product_id'       => $product_id,
            'color_id'         => $request->color,
            'size_id'          => $request->size,
            'stock'            => $request->stock,
            'additional_price' => $request->additional_price,
        ]);

        return redirect(route('backend.product.inventory.index', $inventory->product->id))->with('success', 'Inventory Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();

        return back()->with('success', 'Inventory Deleted');
    }
}
