<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Guest;
use App\RoomBooking;
use App\BookingRoomMapping;
use Carbon\Carbon;
use App\GuestPayment;
use DB;

class PaymentController extends Controller
{
    //
    public function findGuestPayment(Request $request)
    {
        //guest booked room
        $room_booked = RoomBooking::latest()->where('guest_id', $request->guest_id)
        ->where('checking', 0)
        ->first();
        
        $output = '';

        if($room_booked) {
            $rooms = $room_booked->bookingRooms;        
        
            //find room rate calculation
            $rate = 0;
            $vat = 0;
            if($rooms) {
               foreach($rooms as $room) {
                   $rate += $room->room->roomCategory->rate;
               } 
            }
            $rate = $rate+$vat;
    
            //html form
            
    
            $output .= '<div class="row">';
            $output .= '<div class="col-md-6">';
            $output .= '<h3 class="payment_section_title">Room Information</h3>';
            $output .= '<input type="hidden" name="room_book_id" value="'.$room_booked->id.'">';
            if($rooms) {
                $output .= '<table class="table">';
                $output .= '<tr>';
                $output .= '<th>Room No</th>';
                $output .= '<th>Type</th>';
                $output .= '<th>Rate</th>';
                $output .= '</tr>';
                foreach($rooms as $room) {
                    $output .= '<tr>';
                    $output .= '<td>'.$room->room->room_no.'</td>';
                    $output .= '<td>'.$room->room->roomCategory->name.'</td>';
                    $output .= '<td>'.$room->room->roomCategory->rate.'</td>';
                    $output .= '</tr>';
                }            
                //checkpreviouse Due
                // $_due = GuestPayment::groupBy('guest_id')->where('guest_id', $request->guest_id)
                // ->selectRaw('sum(paid_amount) as total_paid')
                // ->selectRaw('sum(discount) as total_discount')
                // ->selectRaw('sum(grand_total) as total_amount')->get();
    
    
                $output .= '</table>';
            }
            $output .= '</div>';
    
            $output .= '<div class="col-md-6">';
            $output .= '<h3 class="payment_section_title">Billing Information</h3>';
            $output .= '<table class="payment_table">
                <tr>
                    <th>Sub Total</th>
                    <td><input type="number" step="any" class="form-control" id="_subtotal" name="subtotal" value="'.$rate.'" readonly></td>
                </tr>
                <tr>
                    <th>Vat</th>
                    <td><input type="number" step="any" class="form-control" id="_vat" name="vat" placeholder="0.00" value="'.$vat.'" readonly></td>
                </tr>
                <tr>
                    <th>Discount</th>
                    <td><input type="number" step="any" class="form-control" id="_discount" name="discount" placeholder="0.00"></td>
                </tr>
                <tr>
                    <th>Grand Total</th>
                    <td><input type="number" step="any" class="form-control" id="_total" name="total" value="'.$rate.'" readonly></td>
                </tr>
                <tr>
                    <th>Paid Amount</th>
                    <td><input type="number" step="any" class="form-control" id="_paid" name="paid_amount" placeholder="0.00"></td>
                </tr>
                <tr>
                    <th>Due Amount</th>
                    <td><input type="number" step="any" class="form-control" id="_due" name="due_amount" value="'.$rate.'" readonly></td>
                </tr>
            </table>';
            $output .= '</div>';
    
            $output .= '</div>';
        }
        else {
            $output = 'no record found';
        }

        

        return $output;
        
    }

    public function paymentStore(Request $request)
    {
        $ruels = [
            'guest' => 'required',
            'payment_date' => 'required',
            'payment_method' => 'required'
        ];

        $payment_method = ['bkash', 'rocket'];
        if('bkash' == $request->payment_method && 'rocket' == $request->payment_method) 
        {
            $ruels = [
                'guest' => 'required',
                'payment_date' => 'required',
                'payment_method' => 'required',
                'transaction' => 'required'
            ];
        }

        if('card' == $request->payment_method) {
            $ruels = [
                'guest' => 'required',
                'payment_date' => 'required',
                'payment_method' => 'required',
                'card' => 'required'
            ];
        }

        $this->validate($request, $ruels);

        if($request->paid_amount == null || $request->paid_amount < 0) {
            return ['type' => 'error', 'title' => 'Paid amount required!', 'message' => 'Paid amount required'];
        }

        //store in Guest payment table
        try{

            DB::beginTransaction();

            //checking value change
            $room_book = RoomBooking::find($request->room_book_id);
            $room_book->checking = 1;
            $room_book->save();

            $payment = new GuestPayment();
            $payment->guest_id = $request->guest;
            $payment->room_booking_id = $request->room_book_id;
            $payment->payment_date = $request->payment_date;
            $payment->payment_method = $request->payment_method;
            $payment->transaction_no = $request->transaction;
            $payment->card_no = $request->card;
            $payment->sub_total = $request->subtotal;
            $payment->discount = $request->discount;
            $payment->vat = $request->vat;
            $payment->grand_total = $request->total;
            $payment->paid_amount = $request->paid_amount;
            $payment->due = $request->due_amount;
            $payment->comment = $request->comments;
            $payment->created_by = Auth::user()->id;
            $payment->save();

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!' ,'message' => 'Payment Received Successfully'];

        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong'];
        }

    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $payment = GuestPayment::find($id);
        $payment->deleted_by = \Auth::user()->id;
        $payment->save();
        if ($payment->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Payment has been deleted successfully.'];
        }
    }


}
