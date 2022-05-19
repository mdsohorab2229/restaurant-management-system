<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buffetcar;
use App\Buffetincludecar;
use Auth;
class BuffetcarController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Car List :: Jannat Restaurant & Resort',
            'page_header' => 'Car List',
            'page_desc' => '',
            'cars' => Buffetcar::all()
        ];

        return view('buffetforcars.index')->with(array_merge($this->data,$data));
    }
    //store car and company
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:buffetcars',
            'address' => 'required',
            'phone1'  => 'required|unique:buffetcars|max:14|min:11|regex:/\+?(88)?0?1[3456789][0-9]{8}\b/',
            'amount' => 'required',
        ]);

        $cars = new Buffetcar();
        $cars->name = $request->name;
        $cars->address = $request->address;
        $cars->phone1 = $request->phone1;
        $cars->phone2 = $request->phone2;
        $cars->phone3 = $request->phone3;
        $cars->amount = $request->amount;
        $cars->created_by = \Auth::user()->email;
        if($cars->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('buffetcars') ,'message' => 'Car Company Added Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Added Car Company Category Successfully'];
    }
    //edit all car data
    public function edit(Request $request)
    {
        $data =  Buffetcar::find($request->car_id);

        return $data;
    }

    //update company/car

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:buffetcars,name,'.$request->car_id,
            'address' => 'required',
            'phone1'  => 'required|max:14|min:11|regex:/\+?(88)?0?1[3456789][0-9]{8}\b/|unique:buffetcars,phone1,'.$request->car_id,
            'amount' => 'required',
        ]);

        $cars = Buffetcar::find($request->car_id);
        $cars->name = $request->name;
        $cars->address = $request->address;
        $cars->phone1 = $request->phone1;
        $cars->phone2 = $request->phone2;
        $cars->phone3 = $request->phone3;
        $cars->amount = $request->amount;
        $cars->updated_by = \Auth::user()->email;
        if($cars->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('buffetcars') ,'message' => 'Car Company Updated Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Car Company Category Successfully'];
    }

    //for destory car/company data
    public function destroy(Request $request, $buffet_id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $car = Buffetcar::find($buffet_id);
        $car->deleted_by = \Auth::user()->email;
        $car->save();
        if ($car->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }

    // car add for buffet

    public function indexbuffet()
    {
        $data = [
            'page_title' => 'Buffet List :: Jannat Restaurant & Resort',
            'page_header' => 'Buffet List',
            'page_desc' => '',
            'buffetcars' => Buffetcar::all(),
            'buffetlists' => Buffetincludecar::all(),
        ];

        return view('buffetforcars.buffet.index')->with(array_merge($this->data,$data));
    }


    //store car and company
    public function storebuffetcar(Request $request)
    {
        $this->validate($request, [
            'buffetcar_id' => 'required',
            'carnumber' => 'required',
            'supervisorname' => 'required',
            'arrivaltime' => 'required',
            'from' => 'required',
            'phone'  => 'required',

            
        ]);

        $buffetcars = new Buffetincludecar();
        $buffetcars->buffetcar_id = $request->buffetcar_id;
        $buffetcars->car_number = $request->carnumber;
        $buffetcars->supervisor_name = $request->supervisorname;
        $buffetcars->phone = $request->phone;
        $buffetcars->arrival_time = $request->arrivaltime;
        $buffetcars->from = $request->from;
        $buffetcars->amount = $request->amount;
        $buffetcars->paid_amount = $request->paidamount;
        $buffetcars->due = $request->due;
        $buffetcars->discription  = $request->discription;
        $buffetcars->created_by = \Auth::user()->email;
        if($buffetcars->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('allbuffetcars') ,'message' => 'Car Buffet Added Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Added Car Buffet Successfully'];
    }

    //edit all Buffet
    public function buffetlistedit(Request $request)
    {
        $data =  Buffetincludecar::find($request->buffetcar_id);

        return $data;
    }

    //for view amount
    public function viewamount(Request $request)
    {
        $data = Buffetcar::find($request->buffetcar_id);
        return $data;
    }

    //Update car and company
    public function buffetlistupdate(Request $request)
    {

        $this->validate($request, [

            'carnumber' => 'required',
            'supervisorname' => 'required',
            'arrivaltime' => 'required',
            'from' => 'required',
            'phone'  => 'required',

        ]);

        $buffetcars = Buffetincludecar::find($request->buffet_id);
        $buffetcars->buffetcar_id = $request->name;
        $buffetcars->car_number = $request->carnumber;
        $buffetcars->supervisor_name = $request->supervisorname;
        $buffetcars->phone = $request->phone;
        $buffetcars->arrival_time = $request->arrivaltime;
        $buffetcars->from = $request->from;
        $buffetcars->amount = $request->amount;
        $buffetcars->paid_amount = $request->paidamount;
        $buffetcars->due = $request->due;
        $buffetcars->discription  = $request->discription;
        $buffetcars->updated_by = \Auth::user()->email;
        if($buffetcars->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('allbuffetcars') ,'message' => 'Car Buffet Update Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Upadate Car Buffet Successfully'];
    }

    //for destory car/company include buffet data
    public function buffetdestroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $buffetcar = Buffetincludecar::find($id);
        $buffetcar->deleted_by = \Auth::user()->email;
        $buffetcar->save();
        if ($buffetcar->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }
     
}
