<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info-circle"></i> Order
                (#{{ $orders->order_id }})</h3>
        </div>
        <table class="table table-bordered">
            <thead>
              <tr>
                <td colspan="2">Order Details</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width: 50%;"><address>
                  <strong>Your Store</strong><br>
                  Address 1
                  </address>
                  <b>Telephone</b> {{ $orders->telephone }}<br>
                              <b>E-Mail</b> {{ $orders->email }}<br>
                  <b>Web Site:</b> <a href="#"></a></td>
                <td style="width: 50%;"><b>Date Added</b> {{ date('d-m-Y', strtotime($orders->date_added)) }}<br>
                              <b>Invoice No.</b> {{ $orders->invoice_prefix }}{{ $orders->invoice_no }}<br>
                              <b>Order ID:</b> {{ $orders->order_id }}<br>
                  <b>Payment Method</b> {{ $orders->payment_method }}<br>
                              <b>Shipping Method</b> {{ $orders->shipping_method }}<br>
                  </td>
              </tr>
            </tbody>
          </table>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td style="width: 50%;" class="text-left">Payment Address
                        </td>
                        <td style="width: 50%;" class="text-left">Shipping Address
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left">{{ $orders->firstname }}
                            {{ $orders->lastname }}<br>{{ $orders->payment_company }}<br>{{ $orders->payment_address_1 }}<br>{{ $orders->payment_address_2 }}<br>{{ $orders->payment_city }}
                            {{ $orders->payment_postcode }}<br>{{ $orders->payment_zone }}<br>{{ $orders->payment_country }}
                        </td>
                        <td class="text-left">{{ $orders->shipping_firstname }}
                            {{ $orders->shipping_lastname }}<br>{{ $orders->shipping_company }}<br>{{ $orders->shipping_address_1 }}<br>{{ $orders->shipping_address_2 }}<br>{{ $orders->shipping_city }}
                            {{ $orders->shipping_postcode }}<br>{{ $orders->shipping_zone }}<br>{{ $orders->shipping_country }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td class="text-left">Product</td>
                        <td class="text-left">Model</td>
                        <td class="text-right">Quantity</td>
                        <td class="text-right">Unit Price</td>
                        <td class="text-right">Total</td>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td class="text-left"><a
                                href="#">{{ $orders->name }}</a> <br>
                            {{-- &nbsp;
                            <small> - Select: Blue</small> --}}
                        </td>
                        <td class="text-left">{{ $orders->model }}</td>
                        <td class="text-right">{{ $orders->quantity }}</td>
                        <td class="text-right">{{ $orders->price }}</td>
                        <td class="text-right">
                            {{ $orders->price * $orders->quantity }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Sub-Total</td>
                        <td class="text-right">$80.00</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Flat Shipping Rate</td>
                        <td class="text-right">$5.00</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Eco Tax (-2.00)</td>
                        <td class="text-right">$4.00</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">VAT (20%)</td>
                        <td class="text-right">$17.00</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Total</td>
                        <td class="text-right">$106.00</td>
                    </tr>
                </tbody>

            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>Customer Comment</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>new one</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>