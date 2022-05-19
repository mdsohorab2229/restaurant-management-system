@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        {{-- filltering --}}
        <div class="box box-warning filtering">
            <div class="box-header with-border">
                <h3 class="box-title">Filter Report</h3>
            </div>
            <div class="box-body">
                <div class="table">
                    <div class="table-cell">
                        <div class="row">
                            {!! Form::open(['route' => 'balancesheet.filter', 'method'=> 'get']) !!}
                            {{ csrf_field() }}
                            <div class="col-md-2">
                                <input type="text" name="from_date" class="form-control date-picker" placeholder="From Date" autocomplete="off">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="to_date" class="form-control date-picker" placeholder="To Date" autocomplete="off">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $total = $products->sum(function ($product) {
                        return $product->stock->quantity*$cost = $product->cost;
            });
            //last month total
            $lastmonthtotal = $lastmonthproducts->sum(function ($product) {
                        return $product->stock->quantity*$cost = $product->cost;
             //total last month

            });
             $totallastmonth = $total + $lastmonthtotal;
            //total wasted
            $wasted = $totalwasted->sum(function ($wasted) {
                return $wasted->quantity*$cost = $wasted->product->cost;

            });
            //total kitched stock
            $totalkitchenstoc = $totalkitchenstock->sum(function($totalkitchenstoc){
                return $totalkitchenstoc->quantity*$cost = $totalkitchenstoc->product->cost;

            });
            $totalwasted_kitchenstock = $wasted + $totalkitchenstoc;
            $totalproduct_wasted_kitchen = $total + $wasted + $totalkitchenstoc;
            $purchase=$total+$totalwasted_kitchenstock;
            $cosofgoodssale=$purchase+$totallastmonth;
            $endinv=$totalproduct_wasted_kitchen-$totalwasted_kitchenstock;
            $cost_of_goods_sold=$cosofgoodssale-$endinv;
            $gcs=$cost_of_goods_sold;
            $total=$monthlyexpansesumation->sum('amount')+$gcs;

            //forbankloan
            //forwithdrawwithInterest
            $long_withdraw_And_long_interest=$withdraw_long+$withdraw_interest_long;
            $short_withdraw_And_short_interest=$withdraw_short+$withdraw_interest_short;
            //fordeposit And Interest
            $long_deposit_And_long_interest = $deposit_long+$deposit_interest_long;
            $short_deposit_And_short_interest = $deposit+$deposit_interest_short;

        @endphp
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Balance Sheet</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="balancesheet_table" width="100%">
                    <thead>
                    <tr>

                        <th colspan="4" class="text-center">
                            <h4>Balance Sheet</h4>

                            <h5>{{ $setting->restaurant_name }}</h5>
                            <h5>{{ $currentDateTime }}</h5>
                        </th>

                    </tr>
                    <tr style="background:lightgray;">
                        <th>Assets</th>
                        <th>৳</th>
                        <th>Liabilities</th>
                        <th>৳</th>
                    </tr>
                    </thead>
                    <tr>
                        <th colspan="2">
                            Fixed Assets
                        </th>
                        <th colspan="2">Capital</th>
                    </tr>
                    <tr>
                        <td>
                    @foreach($assets as $key=> $asset)
                        <tr>
                            <td> {{ $asset->assetcategory->name }} </td>
                            <td> {{ number_format($asset->total),2}} </td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                        </td>
                        <th class="text-right">Total Fixed Asset</th>
                        <th>{{ number_format($totalassets),2 }} </th>
                        <td>Owner Investment && Others</td>
                        @if(0 < $cash = $sells-$total)
                            <td>{{ number_format($investment_And_cash = $total_investments+$cash),2 }}</td>

                        @else
                            <td>{{ number_format($investment_And_cash=$total_investments-$cash),2 }}</td>
                            @endif
                            </tr>

                            <tr>
                                <th colspan="2"> Current Assets </th>
                                <th colspan="2"> Current Liabilities </th>
                            </tr>

                            @if(0 < ($sells-$total))
                                <tr>

                                    <td> Cash </td>
                                    <td> {{ number_format($cash = $sells-$total,2) }} </td>


                                </tr>
                            @endif
                            @if(0 < ($deposite-$withdraw))
                                <tr>

                                    <td> Bank </td>
                                    <td> {{ number_format($bank = $deposite-$withdraw),2}} </td>


                                </tr>
                            @endif
                            @if(0 < $endinv)
                                <tr>

                                    <td> Inventory </td>
                                    <td> {{ number_format($endinv,2) }} </td>


                                </tr>
                            @endif

                            @if(0 < ($total_account_receivables))
                                <tr>

                                    <td> Accounts Receivable </td>
                                    <td> {{ number_format($total_account_receivables,2) }} </td>


                                </tr>
                            @endif
                            <tr>
                                <th class="text-right">Total Current Asset</th>
                                @if(0 < $endinv && 0<$total_account_receivables && 0<$bank)
                                    <th>{{ number_format($cash+$bank+$endinv+$total_account_receivables),2 }} </th>
                                @else
                                    <th>{{ number_format($totalcurrent_asset=$cash),2 }} </th>
                                @endif
                                @if(0 > ($total_account_receivables))
                                    <td>Account Payable</td>
                                    <td>
                                        @php
                                            $a=explode("-",$total_account_receivables)

                                        @endphp

                                        {{ number_format($a[1],2) }}
                                    </td>
                                @endif
                            </tr>
                            <tr>

                                <th colspan="2"> </th>
                                <td>Loan</td>
                                <td>{{ number_format($shortime_loan = $short_withdraw_And_short_interest-$short_deposit_And_short_interest),2 }}</td>


                            </tr>

                            <tr>
                                <td colspan="2"></td>
                                <th colspan="2">Non-Current Liabilities</th>

                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>Long Term Bank Loan</td>
                                <td>{{ number_format( $long_withdraw_And_long_interest-$long_deposit_And_long_interest),2 }}</td>

                            </tr>

                            <tr>
                                <th> Total </th>
                                <th> {{ number_format($totalassets+$totalcurrent_asset,2) }} </th>
                                <th> Total </th>
                                <th> {{ number_format($investment_And_cash+$a[1]+$shortime_loan+($long_withdraw_And_long_interest-$long_deposit_And_long_interest),2) }} </th>
                            </tr>
                            <tfoot>
                            <tr>
                                <th class="text-right" colspan="2">Total Calculation :- {{ number_format($totalassets+$totalcurrent_asset,2) }} /= </th>
                                <th class="text-right" colspan="2">Total Calculation :- {{ number_format($investment_And_cash+$a[1]+$shortime_loan+($long_withdraw_And_long_interest-$long_deposit_And_long_interest),2) }} /=</th>
                            </tr>
                            </tfoot>

                </table>
            </div>
            <div class="box-footer"></div>
        </div>
    </div>

@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
    <!-- date-range-picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-timepicker/css/timepickerr.min.css') }}">
    <script src="{{ asset("bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js") }}"></script>

    <script>
        (function ($) {
            "use strict";

            $('.date-picker').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
            });
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            });

            //get bankcategory data
            $(document).ready(function() {
                $('#balancesheet_table').DataTable({

                    dom: 'Brti',
                    buttons: [
                        // 'copy,', 'csv', 'excel', 'pdf', 'print'
                        { extend: 'copyHtml5', footer: true },
                        { extend: 'excelHtml5', footer: true },
                        { extend: 'csvHtml5', footer: true },
                        { extend: 'pdfHtml5', footer: true },
                        { extend: 'print', footer: true },
                    ]
                });
            });


        }(jQuery));
    </script>
@endpush