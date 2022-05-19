<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
    <style>
        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 3mm;
            margin: 0 auto;
            width: 70mm;
            background: #FFF;
            color:black;

        }
        ::selection {background: #f31544; color: #FFF;}

        h1{
            font-size: 2em;
        }
        h2{font-size: 2em;}
        h3{
            font-size: 1.7em;
            font-weight: 300;
            line-height: 2em;
        }
        .customp{
            font-size: 1.4em;
            color: rgba(4, 3, 36,1);
            line-height: .1em;
        }
        .legal {
            line-height: 2em;
            font-size:12px;
        }

        #top, #mid,#bot{ /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }

        #top{min-height: 50px; font-size: 12px;}
        #mid{min-height: 80px;}
        #bot{ min-height: 50px;}



        .info{
            display: block;
        //float:left;
            margin-left: 0;
        }
        .title{
            float: right;
        }
        .title p{text-align: right;}
        table{
            width: 100%;
            border-collapse: collapse;
        }
        td{
        //padding: 5px 0 5px 15px;
        //border: 1px solid #EEE
        }
        .tabletitle{
        //padding: 5px;
            font-size: .7em;
            background: #EEE;
            line-height: 1px;
        }
        .service{border-bottom: 1px solid #EEE;}
        .item{width: 24mm;}
        .itemtext{font-size: .6em;}

        #legalcopy{
            margin-top: 5mm;
        }

        .right_content
        {
            text-align: right;
            padding-top: 1px;
        }
    </style>
</head>
<body>
<div id="dataexample2">
<div id="invoice-POS">

    <center id="top">
        <div class="logo"><img style="width:40px;height:40px;" src="{{ asset('assets/images/gray-jannat.png') }}" alt=""></div>
        <div class="info">
            <h2>{{ $setting->restaurant_name }}</h2>
            <p class="customp">
                {{$setting->address}}
            </p>
            <p class="customp">
                Phone:- {{$setting->phone}}
            </p>
            <p class="customp">
                Email:- {{$setting->email}}
            </p>
            <p class="customp">Vat Reg: 001718828</p>
        </div><!--End Info-->
        <h5 style="font-weight: bold;">Order No : - # {{$orders->order_no}}</h5>
        <div class="right_content">
            {{-- <p class="customp">Customer Name: {{$billings->customer->name}}</p> --}}
            <p class="customp">Date :- {{$orders->created_at}}</p>
        </div>
    </center><!--End InvoiceTop-->




    <div id="bot">

        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h2>Item</h2></td>
                    <td class="Hours"><h2>U.price</h2></td>
                    <td class="Hours"><h2>Qty</h2></td>
                    <td class="Rate"><h2>SubTotal</h2></td>
                </tr>
                @foreach($order_menu_mappinges as $key => $order_menu_mappinge)
                <tr class="service">
                    <td class="tableitem"><p class="itemtext">{{$order_menu_mappinge->menu->name}}</p></td>
                    <td class="tableitem"><p class="itemtext">{{$order_menu_mappinge->sell_price}}</p></td>
                    <td class="tableitem"><p class="itemtext">{{$order_menu_mappinge->quantity}}</p></td>
                    <td class="tableitem"><p class="itemtext">{{$order_menu_mappinge->quantity*$order_menu_mappinge->sell_price}}</p></td>
                </tr>
                @endforeach




                <tr class="tabletitle">
                    <td colspan="2"></td>
                    <td class="Rate"><h2>Subtotal</h2></td>
                    <td class="payment"><h2>{{$orders->sub_total}}</h2></td>
                </tr>

                <tr class="tabletitle">
                    <td colspan="2"></td>
                    <td class="Rate"><h2>Vat</h2></td>
                    <td class="payment"><h2>{{$orders->tax}}</h2></td>
                </tr>
                <tr class="tabletitle">
                    <td colspan="2"></td>
                    <td class="Rate"><h2>Grand Total</h2></td>
                    <td class="payment"><h2>{{ $orders->amount }}</h2></td>
                </tr>

            </table>
        </div><!--End Table-->

        <div id="legalcopy">
            <p class="legal" style="text-align:center"><strong>Thank you!</strong></p>
        </div>

    </div><!--End InvoiceBot-->
</div><!--End Invoice-->
</div>
<script src="{{ URL::asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/vendor/printjs/jquery-printme.js') }}"> </script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#dataexample2").printMe({
            "path" : ["{{ URL::asset('assets/print/token.css') }}"]
        });
        window.close();

    });
</script>
</body>
</html>