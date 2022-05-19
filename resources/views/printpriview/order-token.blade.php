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
    font-size: 1em;
    }
    h2{font-size: 1em;}
    h3{
    font-size: 1.3em;
    font-weight: 300;
    line-height: 2em;
    }
    .customp{
    font-size: .8em;
    color: rgba(4, 3, 36,1);
    line-height: .1em;
    }
    .legal {
    line-height: 1em;
    font-size:9px;
    }

    #top, #mid,#bot{ /* Targets all id with 'col-' */
    border-bottom: 1px solid #EEE;
    }

    #top{min-height: 50px; font-size: 9px;}
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
    font-size: 1.3em;
    background: #EEE;
    line-height: 1px;
    }
    .service{border-bottom: 1px solid #EEE;}
    .item{width: 24mm;}
    .itemtext{font-size: 1.3em;}

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
            {{-- <div class="logo"><img style="width:40px;height:40px;" src="{{ asset('assets/images/gray-jannat.png') }}" alt=""></div> --}}
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
            <h5 style="margin: 0mm">Waiter Name : - {{ $order->user->name }}</h5>
            <h5 style="margin: 0mm">Table : - {{ $order->table->name }}</h5>            
            <h5 style="font-weight: bold;">Order No : - # {{ $order->order_no }}</h5>

        </center><!--End InvoiceTop-->




        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item"><h2>Item</h2></td>
                        <td class="Hours"><h2>Qty</h2></td>
                        <td class="Rate"><h2>Total</h2></td>
                    </tr>
                    @if($order_menus)
                        @foreach($order_menus as $order_menu)
                            <tr class="service">
                                <td class="tableitem"><p class="itemtext">{{ $order_menu->menu->name }}</p></td>

                                <td class="tableitem"><p class="itemtext">{{ $order_menu->quantity }}</p></td>
                                <td class="tableitem"><p class="itemtext">{{ $order_menu->price }}</p></td>
                            </tr>
                        @endforeach
                    @endif







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