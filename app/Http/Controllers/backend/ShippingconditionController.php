<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ShippingCondition;
use Illuminate\Http\Request;

class ShippingconditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingConditions = ShippingCondition::orderBy('id', 'asc')->paginate(5);
        return view('backend.ShippingCondition.index', compact('shippingConditions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location'        => 'required',
            'shipping_amount' => 'required|integer',
        ]);

        ShippingCondition::create([
            'location'        => $request->location,
            'shipping_amount' => $request->shipping_amount,
        ]);

        return back()->with('success', 'Created');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingCondition $shippingCondition)
    {
        return view('backend.ShippingCondition.edit', compact('shippingCondition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingCondition $shippingCondition)
    {
        $request->validate([
            'location'        => 'required',
            'shipping_amount' => 'required|integer',
        ]);

        $shippingCondition->update([
            'location'        => $request->location,
            'shipping_amount' => $request->shipping_amount,
        ]);

        return redirect(route('backend.product.shipping.index'))->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCondition $shippingCondition)
    {
        $shippingCondition->delete();
        return redirect(route('backend.product.shipping.index'))->with('success', 'Deleted');
    }
}
