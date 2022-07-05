<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Status</title>

    <style>

        *, ::after, ::before {
            box-sizing: border-box;
        }

        @media (min-width: 1200px)
        {
            .container {
                max-width: 1140px;
            }
        }

        @media (min-width: 992px)
        {
            .container {
                max-width: 960px;
            }
        }

        @media (min-width: 768px)
        {
            .container {
                max-width: 720px;
            }
        }

        @media (min-width: 576px)
        {
            .container {
                max-width: 540px;
            }
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        @media (min-width: 768px)
        {
            .col-md-12 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        .col-md-12{
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 768px)
        {
            .col-md-6 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        .col-md-6
        {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .text-left
        {
            text-align: left!important;
        }

        .text-right
        {
            text-align: right!important;
        }

        .text-center
        {
            text-align: center!important;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

    </style>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="https://hdradio.com/wp-content/uploads/sites/10/2018/07/HD-Radio-logo-HD-Only-1.jpeg" alt="StoreLogo" width="80">
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 15px;">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{ $data['store_name'] }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <li>Store Address : {{ $data['storeAddr'] }}</li>
                    <li>Store E-mail : {{ $data['storeMail'] }}</li>
                    <li>Store Telephone : {{ $data['storePhone'] }}</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <li>Order ID : {{ $data['order_id'] }}</li>
                    <li>Order Status : {{ $data['status_code'] }}</li>
                    <li>Customer Name : {{ $data['cust_name'] }}</li>
                    <li>Payment Method : {{ $data['pay_method'] }}</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
