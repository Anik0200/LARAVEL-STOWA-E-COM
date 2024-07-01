<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;

class UserorderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->paginate(5);

        return view('frontend.allOrder', compact('orders'));
    }

    // public function invoice(Invoice $invoice)
    // {
    //     $file = public_path() . '/storage/invoice/';

    //     $headers = array(
    //         'Content-Type: application/pdf',
    //     );

    //     response()->download(public_path($file, $invoice->invoice, $headers));

    //     return back();
    // }
}
