<!DOCTYPE html>
<html>
<head>
    <title>Order Token</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono:400,400i,700,700i" rel="stylesheet">
</head>

<body>
    
    <div class="print-container" id="printContent">
        <div class="print-header text-center">
            <img src="{{ asset('assets/images/gray-jannat.png') }}" alt="">
            <h1>Order No:  <span class="text-right">{{ $order->order_no }}</span></h1>

        </div>
        <div class="print-body">
            <table class="table">
                <tr>
                    <th>Dishes</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            
                @if($order_menus)
                    @foreach($order_menus as $order_menu)
                        <tr>
                            <td>{{ $order_menu->menu->name }}</td>
                            <td>{{ $order_menu->quantity }}</td>
                            <td>{{ $order_menu->price }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="print-footer"></div>
    </div>

    <script src="{{ URL::asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/printjs/jquery-printme.js') }}"> </script>
    <script type="text/javascript">
    $(document).ready(function () {

        $("#printContent").printMe({
            "path" : ["{{ URL::asset('assets/print/token.css') }}"],
             "path" : ["{{ URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}"]
        });
        //window.close();

    });
</script>

</body>
</html>