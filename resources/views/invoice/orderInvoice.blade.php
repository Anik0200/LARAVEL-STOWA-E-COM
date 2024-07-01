<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            margin-top: 20px;
            background: #eee;
        }

        .invoice {
            padding: 30px;
        }

        .invoice h2 {
            margin-top: 0px;
            line-height: 0.8em;
        }

        .invoice .small {
            font-weight: 300;
        }

        .invoice hr {
            margin-top: 10px;
            border-color: #ddd;
        }

        .invoice .table tr.line {
            border-bottom: 1px solid #ccc;
        }

        .invoice .table td {
            border: none;
        }

        .invoice .identity {
            margin-top: 10px;
            font-size: 1.1em;
            font-weight: 300;
        }

        .invoice .identity strong {
            font-weight: 600;
        }


        .grid {
            position: relative;
            width: 100%;
            background: #fff;
            color: #666666;
            border-radius: 2px;
            margin-bottom: 25px;
            box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <!-- BEGIN INVOICE -->
            <div class="col-12">
                <div class="grid invoice">
                    <div class="grid-body">
                        <div class="invoice-title">
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2>invoice<br>
                                        <span class="small">order #{{ $order_details->id }}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <address>
                                    <strong>Billed To:</strong><br>
                                    Twitter, Inc.<br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                </address>
                            </div>
                            <div class="col-6 text-right">
                                <address>
                                    <strong>Shipped To:</strong><br>
                                    Elaine Hernandez<br>
                                    P. Sherman 42,<br>
                                    Wallaby Way, Sidney<br>
                                    <abbr title="Phone">P:</abbr> (123) 345-6789
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <address>
                                    <strong>Payment Method:</strong><br>
                                    Visa ending **** 1234<br>
                                    h.elaine@gmail.com<br>
                                </address>
                            </div>
                            <div class="col-6 text-right">
                                <address>
                                    <strong>Order Date:</strong><br>
                                    {{ $order_details->created_at }}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>ORDER SUMMARY</h3>
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="line">
                                            <td><strong>#</strong></td>
                                            <td class="text-center"><strong>Product</strong></td>
                                            <td class="text-center"><strong>Qty</strong></td>
                                            <td class="text-right"><strong>Unit Price</strong></td>
                                            <td class="text-right"><strong>Amount</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderInventories as $orderInventory)
                                            <tr>
                                                <td>{{ $orderInventory->id }}</td>
                                                <td>{{ $orderInventory->inventory->product->title }}</td>
                                                <td class="text-center">{{ $orderInventory->quantity }}</td>
                                                <td class="text-center">
                                                    ${{ $orderInventory->amount + $orderInventory->additional_amount ?? 0 }}
                                                </td>
                                                <td class="text-right">
                                                    ${{ ($orderInventory->amount + $orderInventory->additional_amount ?? 0) * $orderInventory->quantity }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right">
                                                <strong>Coupon
                                                    ({{ $order_details->coupon_name ?? '' }})
                                                </strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>$
                                                    {{ $order_details->coupon_amount ?? 0 }}
                                                </strong>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right">
                                                <strong>Shipping</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>$
                                                    {{ $order_details->shipping_charge }}
                                                </strong>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right"><strong>Total</strong></td>
                                            <td class="text-right">
                                                <strong>$
                                                    {{ $order_details->total }}
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right identity">
                                <p><strong>BY STOWAA</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END INVOICE -->
        </div>
    </div>

</body>

</html>
