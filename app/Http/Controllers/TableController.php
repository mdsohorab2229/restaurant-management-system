<?php

namespace App\Http\Controllers;

use Auth;
use App\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    //
    public function index()
    {
        $data = [
            'page_title' => 'Table lsit :: Jannat Restaurant & Resort',
            'page_header' => 'Tables',
            'page_desc' => '',
            'tables' => Table::all()
        ];

        return view('tables.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tables',
            'capacity' => 'required|numeric'
        ]);

        $table = new Table();
        $table->restaurant_id = 1;
        $table->name = $request->name;
        $table->nickname = $request->nickname;
        $table->capacity = $request->capacity;
        $table->created_by = \Auth::user()->email;
        if($table->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('table') ,'message' => 'Table Created Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to create Table'];

    }
    public function edit(Request $request)
    {
        $data =  Table::find($request->table_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tables,name,'.$request->table_id,
            'capacity' => 'required|numeric'
        ]);

        $table = Table::find($request->table_id);
        $table->name = $request->name;
        $table->nickname = $request->nickname;
        $table->capacity = $request->capacity;
        $table->updated_by = \Auth::user()->email;
        if($table->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('table') ,'message' => 'Table Updated Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to updated Table'];
    }

    public function destroy($id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $table = Table::find($id);
        $table->deleted_by = \Auth::user()->email;
        $table->save();
        if ($table->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Table Deleted Successfully'];
        }
    }
}
