<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shippong</title>
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info-circle"></i> Dispatch Note {{ $orders->order_id }}</h3>
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
                        <td class="text-left">Location</td>
                        <td class="text-left">Refrence</td>
                        <td class="text-right">Product</td>
                        <td class="text-right">Product Weight</td>
                        <td class="text-right">Model</td>
                        <td class="text-right">Quantity</td>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td class="text-left"></a><br></td>
                        <td class="text-left"></td>
                        <td class="text-right">{{ $orders->name }}</td>
                        <td class="text-right"></td>
                        <td class="text-right">{{ $orders->model }}</td>
                        <td class="text-right">{{ $orders->quantity }}</td>
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