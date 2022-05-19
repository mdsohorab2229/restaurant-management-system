<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discountcard;
use App\Customer;
use App\Customerdiscount;
use Auth;
class DiscountCardController extends Controller
{
    public function index()
    {
        $data = [
            'page_title'  => 'Discount Card List :: Jannat Restaurant & Resort',
            'page_header' => 'Discount Card List',
            'page_desc'   => '',
            'discountcards'      => Discountcard::all(),
            'customers'   => Customer::all(),
        ];

        return view('discountcard.index')->with(array_merge($this->data,$data));
    }
   //store discountcard
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer'   => 'required',
            'cardnumber' => 'required|unique:discountcards',
            'discount'   => 'required',
            'expiredate' => 'required',
        ]);

        $discoundcard = new Discountcard();
        $discoundcard->customer_id = $request->customer;
        $discoundcard->cardnumber = $request->cardnumber;
        $discoundcard->discount   = $request->discount;
        $discoundcard->expiredate = $request->expiredate;
        $discoundcard->created_by = \Auth::user()->email;
        if($discoundcard->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('discountcard') ,'message' => 'Discountcard Stored Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Discountcard Successfully'];
    }

    public function edit(Request $request)
    {
        $data =  Discountcard::find($request->discountcard_id);

        return $data;
    }

    //update discountcard
    public function update(Request $request)
    {
        $this->validate($request, [
            'customer'   => 'required',
            'cardnumber' => 'required|unique:discountcards,cardnumber,'.$request->discountcard_id,
            'discount'   => 'required',
            'expiredate' => 'required',
        ]);

        $discoundcard = Discountcard::find($request->discountcard_id);
        $discoundcard->customer_id = $request->customer;
        $discoundcard->cardnumber = $request->cardnumber;
        $discoundcard->discount   = $request->discount;
        $discoundcard->expiredate = $request->expiredate;
        $discoundcard->updated_by = \Auth::user()->email;
        if($discoundcard->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('discountcard') ,'message' => 'Discountcard Update Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Update Discountcard Successfully'];
    }

    //for destroy

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $discoundcard = Discountcard::find($id);
        $discoundcard->deleted_by = \Auth::user()->email;
        $discoundcard->save();
        if ($discoundcard->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Discountcard has been deleted successfully.'];
        }
    }

    //view all discount list
    public function discountindex()
    {
        $data = [
            'page_title'   => 'Discount List :: Jannat Restaurant & Resort',
            'page_header'  => 'Discount List',
            'page_desc'    => '',
            'discountcards'=> Discountcard::all(),
            'customers'    => Customer::all(),
        ];

        return view('discountcard.discountlist.index')->with(array_merge($this->data,$data));
    }

    //store discount customer
    public function discountstore(Request $request)
    {
        $this->validate($request, [
            'customer' => 'required',
            'carnumber'   => 'required',
        ]);

        $discoundcard = new Customerdiscount();
        $discoundcard->customer_id = $request->customer;
        $discoundcard->discountcard_id   = $request->carnumber;
        $discoundcard->created_by = \Auth::user()->email;
        if($discoundcard->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('discountlist') ,'message' => 'Customer Discount Stored Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Customer Discount Successfully'];
    }

    public function discountedit(Request $request)
    {
        $data =  Customerdiscount::find($request->customerdiscount_id);

        return $data;
    }

    //for destroy

    public function discountcustomerdestroy(Request $request, $customerdiscount_id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $discoundcustomer = Customerdiscount::find($customerdiscount_id);
        $discoundcustomer->deleted_by = \Auth::user()->email;
        $discoundcustomer->save();
        if ($discoundcustomer->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Customer Discount has been deleted successfully.'];
        }
    }

}
