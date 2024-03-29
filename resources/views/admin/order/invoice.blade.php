<!--
    THIS IS INVOICE PAGE
    ----------------------------------------------------------------------------------------------
    invoice.blade.php
    It's used for Generate Order Invoice
    ----------------------------------------------------------------------------------------------
-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order</title>

    <!-- Bootstarp -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Custom CSS -->
    <style>
        *{
            box-sizing: border-box;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }
    </style>
    <!-- End Custom CSS -->

</head>

<body>
    @foreach ($order as $orders)
        <div class="container-fluid mb-5">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-right mt-2 mb-2 text-secondary">INVOICE</h2>
                    <hr>
                    @if(isset($orders))
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-2">
                                    {{ getStoreDetails($orders->store_id,'config_name') }} <br>
                                    @php
                                    $address =  getStoreDetails($orders->store_id,'config_address');
                                    $rep = str_replace(',','</br>',$address);
                                    echo $rep;
                                    @endphp <br>
                                    <b>Telephone : </b> {{ getStoreDetails($orders->store_id,'config_telephone') }} <br>
                                    {{ getStoreDetails($orders->store_id,'config_email') }} <br>
                                    {{ getStoreDetails($orders->store_id,'config_ssl') }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <table align="right" cellpadding="7">
                                    <tr>
                                        <td><b>Date Added</b></td>
                                        <td>:</td>
                                        <td>{{ isset($orders->date_added) ? $orders->date_added : "" }}</td>
                                    </tr>
                                    @if($orders->invoice_no != 0 || $orders->invoice_no != '')
                                        <tr>
                                            <td><b>Invoice No.</b></td>
                                            <td>:</td>
                                            <td>@if($orders->invoice_no != 0){{ isset($orders->invoice_prefix) ? $orders->invoice_prefix : "" }}{{ isset($orders->invoice_no) ? $orders->invoice_no : "" }}@endif</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td><b>Order ID</b></td>
                                        <td>:</td>
                                        <td>{{ isset($orders->order_id) ? $orders->order_id : "" }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Payment Method</b></td>
                                        <td>:</td>
                                        <td>{{ isset($orders->payment_method) ? $orders->payment_method : "" }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th style="width: 50%;">To</th>
                                            <th style="width: 50%;">Ship To (if different address)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ isset($orders->firstname) ? $orders->firstname : "" }} {{ isset($orders->lastname) ? $orders->lastname : "" }} <br>
                                                {{ isset($orders->payment_address_1) ? $orders->payment_address_1 : "" }} <br>
                                                {{ isset($orders->payment_city) ? $orders->payment_city : "" }} {{ isset($orders->payment_postcode) ? $orders->payment_postcode : "" }}<br>
                                                {{ isset($orders->email) ? $orders->email : "" }}<br>
                                                {{ isset($orders->telephone) ? $orders->telephone : "" }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Product</th>
                                            <th>Model</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($orders['hasManyOrderProduct']))
                                            @foreach ($orders['hasManyOrderProduct'] as $order)
                                                <tr>
                                                    <td>
                                                        {{ htmlspecialchars_decode($order->name) }}
                                                        @php
                                                            $strip = strip_tags($order->toppings);
                                                            $replace = str_replace('+','</br> + ',$strip);
                                                            echo $replace
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{ isset($order->model) ? $order->model : "" }}
                                                    </td>
                                                    <td>
                                                        {{ isset($order->quantity) ? $order->quantity : "" }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($order->price,2) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($order->total,2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        @if (isset($orders['hasManyOrderTotal']))
                                            @foreach ($orders['hasManyOrderTotal'] as $total)
                                                <tr>
                                                    <td colspan="4" align="right">
                                                        <b>{{ strtoupper($total->title) }}</b>
                                                    </td>
                                                    <td align="right">
                                                        <b>{{ isset($total->text) ? $total->text : "" }}</b>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <hr class="text-dark">
    @endforeach
</body>

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<!-- END SCRIPT -->

</html>
