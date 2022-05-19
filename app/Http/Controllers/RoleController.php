<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
class RoleController extends Controller
{
    //role lists
    public function index()
    {

        $roles = Role::all();
        $data = [
            'page_title' => 'Roles',
            'page_header' => 'Roles',
            'page_description' => '',
            'roles' => $roles
        ];

        return view('roles.index')->with(array_merge($this->data, $data));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;

        if($role->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('role.list'), 'message' => 'Role has been created successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to create role'];
    }

    public function edit(Request $request)
    {
        $role =  Role::find($request->role_id);
        return $role;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $role = Role::find($request->role_hidden_id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;

        if($role->save()) {
            return ['type' => 'success', 'title' => 'Updated!', 'redirect' => route('role.list'), 'message' => 'Role has been Updated successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Update role'];
    }

    public function delete($id)
    {
        //
        Role::find($id)->delete();
        return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Role Deleted Successfully.'];
    }
}
