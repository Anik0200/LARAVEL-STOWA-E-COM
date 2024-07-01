<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponControoler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'asc')->paginate(5);
        return view('backend.Coupon.index', compact('coupons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|max:11',
            'amount'           => 'required|integer',
            'applicale_amount' => 'required|integer',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date',
        ]);

        Coupon::create([
            'name'             => $request->name,
            'amount'           => $request->amount,
            'applicale_amount' => $request->applicale_amount,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
        ]);

        return back()->with('success', 'Created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {

        return view('backend.Coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name'             => 'required|max:11',
            'amount'           => 'required|integer',
            'applicale_amount' => 'required|integer',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date',
        ]);

        $coupon->update([
            'name'             => $request->name,
            'amount'           => $request->amount,
            'applicale_amount' => $request->applicale_amount,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
        ]);

        return redirect(route('backend.product.coupon.index'))->with('success', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect(route('backend.product.coupon.index'))->with('success', 'Updated!');
    }
}
