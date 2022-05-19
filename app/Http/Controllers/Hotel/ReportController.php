<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GuestPayment;
use App\BookingRoom;
use App\Guest;
use Carbon\Carbon;
use DB;
class ReportController extends Controller
{
    //
    public function index()
    {
        $data = [
            'page_title' => 'Payment Report',
            'page_header' => 'Payment Report',
            'page_desc' => '',
            'guestList' => Guest::all(),
        ];

        return view('hotel.reports.index')->with(array_merge($this->data, $data));
    }

    public function paymentReport()
    {
        $data = [
            'page_title' => 'Payment Report',
            'page_header' => 'Payment Report',
            'page_desc' => '',
            'guestList' => Guest::all(),
            'payments' => GuestPayment::where('payment_date', Carbon::today())->paginate(20)
        ];

        return view('hotel.reports.payment')->with(array_merge($this->data, $data));
    }

    public function filterPayment(Request $request)
    {
        if ($request->from_date || $request->to_date) {
            if ($request->from_date) {
                $payments = GuestPayment::where(DB::raw('date(payment_date)'), $request->from_date)->with(['roombooking', 'guest'])->orderBy('id', 'DESC')->get();
            }
            if ($request->from_date && $request->to_date) {
                $payments = GuestPayment::whereBetween(DB::raw('date(payment_date)'), [$request->from_date, $request->to_date])->with(['roombooking', 'guest'])->orderBy('id', 'DESC')->get();


            }

            $data = [
                'page_title' => 'Payment Report',
                'page_header' => 'Payment Report',
                'page_desc' => '',
                'payments' => $payments,
                'form_date' => $request->from_date,
                'to_date' => $request->to_date,
                'guestList' => Guest::all(),
            ];

            return view('hotel.reports.search-payment')->with(array_merge($this->data, $data));
        }
    }



    public function guestReport()
    {
        $data = [
            'page_title' => 'Guest Reports',
            'page_header' => 'Guest Reports',
            'page_desc' => '',
            'guestList' => Guest::all(),
            'guests' => Guest::all()
        ];

        return view('hotel.reports.guest')->with(array_merge($this->data, $data));
    }

}
