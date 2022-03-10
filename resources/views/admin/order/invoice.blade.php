<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <div style="page-break-after: always;">
        <h3 class="text-right">Invoice</h3>
        <table class="store table-bordered w-100">
            <tbody>
                <tr>
                    <td>{{ $orders->firstname }} {{ $orders->lastname }}<br>
                        {{ $orders->payment_address_1 }},<br>
                        {{ $orders->city }}<br>
                        Telephone: {{ $orders->telephone }}<br>
                        {{ $orders->email }}<br>
                        {{ $orders->store_url }}</td>
                    <td align="right" valign="top">
                        <table>
                            <tbody>
                                <tr>
                                    <td><b>Date Added:</b></td>
                                    <td>{{ $orders->date_added }}</td>
                                </tr>
                                <tr>
                                    <td><b>Invoice No.:</b></td>
                                    <td>{{ $orders->invoice_prefix }}{{ $orders->invoice_no }}</td>
                                </tr>
                                <tr>
                                    <td><b>Order ID:</b></td>
                                    <td>{{ $orders->order_id }}</td>
                                </tr>
                                <tr>
                                    <td><b>Payment Method:</b></td>
                                    <td>{{ $orders->payment_method }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="address table-bordered w-100 mt-3">
            <tbody>
                <tr class="heading table-secondary">
                    <td width="50%"><b>To</b></td>
                    <td width="50%"><b>Ship To (if different address)</b></td>
                </tr>
                <tr>
                    <td>{{ $orders->firstname }}
                        {{ $orders->lastname }}<br>{{ $orders->payment_address_1 }}<br>{{ $orders->payment_address_2 }}<br>{{ $orders->payment_city }}
                        {{ $orders->payment_postcode }}<br>
                        {{ $orders->email }}<br>
                        {{ $orders->telephone }} </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="product mt-3 table-bordered w-100">
            <table class="table">
                <thead class="table-secondary">
                    <tr>
                        <td class="left">Product</td>
                        <td class="left">Model</td>
                        <td class="right">Quantity</td>
                        <td class="right">Unit Price</td>
                        <td class="right">Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productorders as $order)
                        <tr>
                            <td class="left">{{ htmlspecialchars_decode($order->name) }}
                                <br>
                                {{-- {{ echo $orders->toppings  }} --}}
                                @php
                                    echo $order->toppings;
                                @endphp
                            </td>
                            <td class="left">{{ $order->model }}</td>
                            <td class="right">{{ $order->quantity }}</td>
                            <td class="right">{{ $order->price }}</td>
                            <td class="right">{{ $order->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tbody id="totals">
                    <tr>
                        <td colspan="4" class="right">Sub-Total:</td>
                        <td class="right">{{ $orders->total }}</td>
                    </tr>
                </tbody>
                <tbody id="totals">
                    <tr>
                        <td colspan="4" class="right">Coupon(VALEN10):</td>
                        <td class="right">£-2.10</td>
                    </tr>
                </tbody>
                <tbody id="totals">
                    <tr>
                        <td colspan="4" class="right">Delivery:</td>
                        <td class="right">£1.00</td>
                    </tr>
                </tbody>
                <tbody id="totals">
                    <tr>
                        <td colspan="4" class="right">Service Charge:</td>
                        <td class="right">£0.50</td>
                    </tr>
                </tbody>
                <tbody id="totals">
                    <tr>
                        <td colspan="4" class="right">Total to pay:</td>
                        <td class="right">£20.40</td>
                    </tr>
                </tbody>
            </table>
        </table>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    // $('td').css(padding : '0');
</script>

</html>
