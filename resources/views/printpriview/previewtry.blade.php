<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono:400,400i,700,700i" rel="stylesheet">
</head>

<body>

    <div id="dataexample2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="invoice-title">

                        <h2>Invoice</h2>
                    </div>

                    <hr>
                    <div class="header text-center">
                        <h4>Jannat Restaurant & Resort</h4>
                        <h5>{{$setting->address}}</h5>
                        <h5 style="font-weight: bold;">Order No : - # {{$orders->order_no}}</h5>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">

                        </div>
                        <div class="col-xs-6 text-right">
                            <address>
                                <strong>Custome Name:</strong><br>
                                {{$billings->customer->name}}<br>

                                Date :- {{$billings->created_at}}
                            </address>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Order summary</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <td><strong>Item</strong></td>
                                            <td class="text-center"><strong>Price</strong></td>
                                            <td class="text-center"><strong>Quantity</strong></td>
                                            <td class="text-right"><strong>Totals</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order_menu_mappinges as $key => $order_menu_mappinge)
                                        <tr>
                                            <td>{{$order_menu_mappinge->menu->name}}</td>
                                            <td class="text-center">{{$order_menu_mappinge->sell_price}}</td>
                                            <td class="text-center">{{$order_menu_mappinge->quantity}}</td>
                                            <td class="text-right">{{$order_menu_mappinge->quantity*$order_menu_mappinge->sell_price}}</td>
                                        </tr>
                                        @endforeach

                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                            <td class="thick-line text-right">{{$orders->sub_total}}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>Discount</strong></td>
                                            <td class="no-line text-right">{{$orders->discount}}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>Due</strong></td>
                                            <td class="no-line text-right">{{$billings->due}}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>Vat</strong></td>
                                            <td class="no-line text-right">{{$orders->tax}}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>Total</strong></td>
                                            <td class="no-line text-right">{{$orders->amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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