<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\ShippingCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts              = Cart::with('inventory')->where('user_id', auth()->user()->id)->get();
        $shippingConditions = ShippingCondition::get();
        $shippinglocation   = ShippingCondition::first();

        return view('frontend.cart.index', compact('carts', 'shippingConditions', 'shippinglocation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                "inventory" => 'required',
                "total"     => 'required',
                "quantity"  => 'required',
            ]
        );

        Cart::create([
            "user_id"      => auth()->user()->id,
            "inventory_id" => $request->inventory,
            "cart_total"   => $request->total,
            "quantity"     => $request->quantity,
        ]);

        return redirect(route('frontend.cart.index'))->with('success', 'Product Added');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $cart = Cart::where('user_id', $request->user_id)->where('id', $request->cart_id)->first();

        $cart->update([
            'quantity'   => $request->quantity,
            'cart_total' => $request->total_price,
        ]);

        $cart_total = Cart::where('user_id', auth()->user()->id)->sum('cart_total');

        if ($request->shipping_id) {

            $ShippingCondition = ShippingCondition::where('id', $request->shipping_id)->first();
            $grand_total       = ($cart_total - (Session::get('cuppon')['amount'] ?? 0)) + $ShippingCondition->shipping_amount;
        } else {

            $grand_total = $cart_total - (Session::get('cuppon')['amount'] ?? 0);
        }

        $data = [
            'cart_total'  => $cart_total,
            'grand_total' => $grand_total,
        ];

        return response()->json($data);
    }

    /**
     * applyCoupon
     */
    public function applyCoupon(Request $request)
    {

        $coupon     = Coupon::where('name', $request->coupon)->first();
        $cart_total = Cart::where('user_id', auth()->user()->id)->sum('cart_total');

        //

        if (!$coupon == null) {

            if ($coupon->start_date < now()) {

                if ($cart_total > $coupon->applicale_amount) {

                    if ($coupon->end_date > now()) {

                        $applyCoupon = [
                            'name'   => $coupon->name,
                            'amount' => $coupon->amount,
                        ];

                        Session::put('cuppon', $applyCoupon);
                        return back();
                        //
                    } else {

                        return 'Card Date Expire!';
                    }
                    //
                } else {

                    return 'Card Amount Not Suffecent!';
                }
                //
            } else {

                return 'Invalid Coupon!';
            }
            //
        } else {

            return 'Coupon No Availaable!';
        }
        //
    }

    /**
     * apply Shipping
     */
    public function applyShipping(Request $request)
    {

        $data = ShippingCondition::where('id', $request->shipping_id)->first();

        $cart_total = Cart::where('user_id', auth()->user()->id)->sum('cart_total');

        $grand_total = ($cart_total - (Session::get('cuppon')['amount'] ?? 0)) + $data->shipping_amount;

        $shipping_data = [
            'location'        => $data->location,
            'shipping_amount' => $data->shipping_amount,
            'grand_total'     => $grand_total,
        ];

        Session::put('shipping_charge', $data->shipping_amount);

        return response()->json($shipping_data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function checkOutview()
    {

        $carts = Cart::with('inventory')->where('user_id', auth()->user()->id)->get();

        return view('frontend.cart.checkOut', compact('carts'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Cart Deleted');
    }
}
