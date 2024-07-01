<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\InventoryOrder;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        if ($request->order_id) {

            $orders = Order::where(function ($q) use ($request) {

                if ($request->order_id) {

                    $q->where('id', 'LIKE', "%" . $request->order_id . "%");

                }

                if ($request->order_status) {

                    $q->where('order_status', $request->order_status);

                }

                if ($request->payment_status) {

                    $q->where('payment_status', $request->payment_status);

                }

                if ($request->form_date && $request->to_date) {

                    $q->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $request->form_date), Carbon::createFromFormat('Y-m-d', $request->to_date)]);

                }

                if ($request->form_date && $request->to_date == null) {

                    $q->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $request->form_date));

                }

            })->paginate(5)->withQueryString();

        } else {

            $orders = Order::select('id', 'user_id', 'total', 'order_status', 'payment_status', 'created_at')->paginate(5);
        }

        return view('backend.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $inventoryOrders = InventoryOrder::where('order_id', $order->id)->get();

        return view('backend.order.show', compact('order', 'inventoryOrders'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update([
            'order_status' => $request->order_status,
        ]);

        return redirect(route('backend.order.index'));
    }
}
