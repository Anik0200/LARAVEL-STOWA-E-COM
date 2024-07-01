<?php

namespace App\Http\Controllers;

use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\InvoiceOrder;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\InventoryOrder;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\UserInfo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SslCommerzPaymentController extends Controller
{
    public function index(Request $request)
    {
        // User Information
        $request->validate(
            [
                'billing_name'    => 'required',
                'billing_email'   => 'required',
                'billing_phone'   => 'required',
                'billing_address' => 'required',
            ],
            [
                'billing_name'    => 'Name Is Required!',
                'billing_email'   => 'Email Is Required!',
                'billing_phone'   => 'Phone Is Required!',
                'billing_address' => 'Address Is Required!',
            ],
        );

        UserInfo::updateOrcreate(
            [
                'user_id' => auth()->user()->id,
            ],
            [
                'user_id' => auth()->user()->id,
                'phone'   => $request->billing_phone,
                'address' => $request->billing_address,
                'city'    => $request->billing_city,
                'zip'     => $request->billing_postcode,
            ],
        );

        // Cart Information
        $carts = Cart::where('user_id', auth()->user()->id)->get();

        $sub_total = 0;

        foreach ($carts as $cart) {

            if ($cart->quantity > $cart->inventory->stock) {

                return back()->with('stock', $cart->inventory->product->title . ' Are Only ' . $cart->inventory->stock . ' Item In Stock');
            }

            $price = (($cart->inventory->product->sale_price ?? $cart->inventory->product->price) + $cart->inventory->additional_price) * $cart->quantity;

            $sub_total += $price;
        }

        if (Session::has('shipping_charge') && Session::has('cuppon')) {

            $grand_total = ($sub_total + Session::get('shipping_charge')) - Session::get('cuppon')['amount'];
        } else {

            $grand_total = $sub_total + Session::get('shipping_charge');
        }

        $post_data                 = [];
        $post_data['total_amount'] = $grand_total;
        $post_data['currency']     = 'BDT';
        $post_data['tran_id']      = uniqid();

        // CUSTOMER INFORMATION
        $post_data['cus_name']     = auth()->user()->name;
        $post_data['cus_email']    = auth()->user()->email;
        $post_data['cus_add1']     = auth()->user()->UserInfo->address ?? '';
        $post_data['cus_add2']     = '';
        $post_data['cus_city']     = auth()->user()->UserInfo->city ?? '';
        $post_data['cus_state']    = '';
        $post_data['cus_postcode'] = auth()->user()->UserInfo->zip ?? '';
        $post_data['cus_country']  = 'Bangladesh';
        $post_data['cus_phone']    = auth()->user()->UserInfo->phone ?? '';
        $post_data['cus_fax']      = '';

        // SHIPMENT INFORMATION
        $post_data['ship_name']     = 'Store Test';
        $post_data['ship_add1']     = 'Dhaka';
        $post_data['ship_add2']     = 'Dhaka';
        $post_data['ship_city']     = 'Dhaka';
        $post_data['ship_state']    = 'Dhaka';
        $post_data['ship_postcode'] = '1000';
        $post_data['ship_phone']    = '';
        $post_data['ship_country']  = 'Bangladesh';

        $post_data['shipping_method']  = 'NO';
        $post_data['product_name']     = 'Computer';
        $post_data['product_category'] = 'Goods';
        $post_data['product_profile']  = 'physical-goods';

        // OPTIONAL PARAMETERS
        $post_data['value_a'] = 'ref001';
        $post_data['value_b'] = 'ref002';
        $post_data['value_c'] = 'ref003';
        $post_data['value_d'] = 'ref004';

        // Order Table Data Insert

        $insertOrder = Order::create([
            'user_id'         => auth()->user()->id,
            'total'           => $post_data['total_amount'],
            'transaction_id'  => $post_data['tran_id'],
            'coupon_name'     => Session::get('cuppon')['name'] ?? null,
            'coupon_amount'   => Session::get('cuppon')['amount'] ?? null,
            'shipping_charge' => Session::get('shipping_charge'),
            'order_status'    => 'Pending',
            'payment_status'  => 'Unpaid',
            'order_note'      => $request->order_comments,
        ]);

        //  payment_status

        if ($insertOrder) {
            foreach ($carts as $cart) {
                $in = InventoryOrder::create([
                    'order_id'          => $insertOrder->id,
                    'inventory_id'      => $cart->inventory_id,
                    'quantity'          => $cart->quantity,
                    'amount'            => $cart->inventory->product->sale_price ?? $cart->inventory->product->price,
                    'additional_amount' => $cart->inventory->additional_price ?? null,
                ]);
            }
        }

        if ($request->ship_different && $insertOrder) {

            $request->validate(
                [
                    'shipping_name'    => 'required',
                    'shipping_phone'   => 'required',
                    'shipping_address' => 'required',
                ],

                [
                    'shipping_name'    => 'Name Is Required!',
                    'shipping_phone'   => 'Phone Is Required!',
                    'shipping_address' => 'Address Is Required!',
                ],
            );

            ShippingAddress::create([

                'order_id' => $insertOrder->id,
                'name'     => $request->shipping_name,
                'phone'    => $request->shipping_phone,
                'address'  => $request->shipping_address,
                'city'     => $request->shipping_city,
                'zip'      => $request->shipping_zip,

            ]);
        }

        $sslc = new SslCommerzNotification();
        // initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = [];
        }

        // return back()->with('success', 'Insert SuccessFull!');
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount  = $request->input('amount');

        $sslc = new SslCommerzNotification();

        $order_details = Order::where('transaction_id', $tran_id)->first();

        $orderInventories = InventoryOrder::where('order_id', $order_details->id)->get();

        if ($order_details->order_status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount);

            if ($validation) {
                $order_details->update([
                    'order_status'   => 'Processing',
                    'payment_status' => 'Paid',
                ]);

                foreach ($orderInventories as $orderInventory) {
                    Inventory::where('id', $orderInventory->inventory_id)->decrement('stock', $orderInventory->quantity);
                    Cart::where('inventory_id', $orderInventory->inventory_id)->where('user_id', $order_details->user_id)->delete();
                }

                $request->session()->forget(['cuppon', 'shipping_charge']);

                $pdf = Pdf::loadView('invoice.orderInvoice', compact('order_details', 'orderInventories'));

                $pdf->save(public_path('storage/invoice/' . $order_details->id . "_invoice.pdf"));

                $pdfPath = url('/') . '/storage/invoice/' . $order_details->id . "_invoice.pdf";

                Invoice::create([
                    'order_id'     => $order_details->id,
                    'invoice_path' => $pdfPath,
                    'invoice'      => $order_details->id . "_invoice.pdf",
                ]);

                Mail::to($order_details->user->email)->send(new InvoiceOrder($order_details));

                return redirect(route('frontend.shop'))->with('success', 'Order Placed');
            }

        } elseif ($order_details->order_status == 'Processing' || $order_details->payment_status == 'Paid') {

            return redirect(route('frontend.shop'))->with('success', 'order placed');
        } else {

            return back()->with('error', 'Invalid');
        }

    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = Order::where('transaction_id', $tran_id)
            ->select('id', 'transaction_id', 'order_status', 'total', 'payment_status', 'user_id')
            ->first();

        if ($order_details->order_status == 'Pending') {

            $order_details->update([
                'order_status' => 'Failed',
            ]);

            $request->session()->forget(['cuppon', 'shipping_charge']);

            return redirect(route('frontend.cart.index'))->with('error', 'Order Failed');

        } elseif ($order_details->order_status == 'Processing') {

            return redirect(route('frontend.shop'))->with('success', 'order placed');
        } else {

            return back()->with('error', 'Invalid');
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = Order::where('transaction_id', $tran_id)
            ->select('id', 'transaction_id', 'order_status', 'total', 'payment_status', 'user_id')
            ->first();

        if ($order_details->order_status == 'Pending') {

            $order_details->update([
                'order_status' => 'Canceled',
            ]);

            $order_details = Order::where('transaction_id', $tran_id)->first();

            $orderInventories = InventoryOrder::where('order_id', $order_details->id)->delete();

            $request->session()->forget(['cuppon', 'shipping_charge']);

            return redirect(route('frontend.cart.index'))->with('error', 'Order Failed');

        } elseif ($order_details->order_status == 'Processing') {

            return redirect(route('frontend.shop'))->with('success', 'order placed');
        } else {

            return back()->with('error', 'Invalid');
        }
    }

    public function ipn(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount  = $request->input('amount');

        $sslc = new SslCommerzNotification();

        $order_details = Order::where('transaction_id', $tran_id)
            ->select('id', 'transaction_id', 'order_status', 'total', 'payment_status', 'user_id')
            ->first();

        $orderInventories = InventoryOrder::where('order_id', $order_details->id)->get();

        if ($order_details->order_status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount);

            if ($validation) {
                $order_details->update([
                    'order_status'   => 'Processing',
                    'payment_status' => 'Paid',
                ]);

                foreach ($orderInventories as $orderInventory) {
                    Inventory::where('id', $orderInventory->inventory_id)->decrement('stock', $orderInventory->quantity);
                    Cart::where('inventory_id', $orderInventory->inventory_id)->where('user_id', $order_details->user_id)->delete();
                }

                $request->session()->forget(['cuppon', 'shipping_charge']);

                return redirect(route('frontend.shop'))->with('success', 'Order Placed');
            }

        } elseif ($order_details->order_status == 'Processing' || $order_details->payment_status == 'Paid') {

            return redirect(route('frontend.shop'))->with('success', 'order placed');
        } else {

            return back()->with('error', 'Invalid');
        }
    }
}
