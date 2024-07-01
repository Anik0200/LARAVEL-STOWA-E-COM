<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::withTrashed()->paginate(5);
        return view('backend.ProductColor.index', compact('colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
        ]);

        Color::create([
            'name' => $request->name,
        ]);

        return back()->with('success, Color Added');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $color = Color::find($id);
        return view('backend.ProductColor.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:20',
        ]);

        $color = Color::find($id);

        $color->update([
            'name' => $request->name,
        ]);

        return redirect(route('backend.product.color.index'))->with('success', 'Color Updated');
    }

    /**
     * softDel the specified resource from storage.
     */
    public function softDel($id)
    {
        $color = Color::find($id);
        $color->delete();

        return back()->with('success, Color Deleted');
    }

    /**
     * Undo the specified resource from storage.
     */
    public function Undo($id)
    {
        $color = Color::onlyTrashed()->find($id);
        $color->restore();

        return back()->with('success, Color Restored');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $color = Color::onlyTrashed()->find($id);
        $color->forceDelete();

        return back()->with('success, Color Deleted');
    }
}
