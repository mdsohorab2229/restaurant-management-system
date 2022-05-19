<?php

namespace App\Http\Controllers;
use Auth;
use Hash;
use App\User;
use Illuminate\Http\Request;
class UsersController extends Controller
{
    /**
     * Class Constructor
     *
     * @author DataTrix Team
     */
    public function __construct()
    {
        // Default variables
        parent::__construct();
    }

    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Users List :: Academy Management',
            'page_header' => 'Users List',
            'page_desc' => '',
            'users' => User::paginate(10),
        ];


        return view('users.index')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Create User :: Academy Management',
            'page_header' => 'Create User',
            'page_desc' => '',
            'roles' => \Auth::user()->canDo('manage_admin') ? \App\Role::all() : \App\Role::where('id', '!=', 1)->get(), // to be changed next time with custom method,
        ];
        return view('users.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'role' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
            'status' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->status = $request->status;
        $user->created_by = \Auth::user()->email;

        if ($user->save()) {
            $user->attachRole($request->role);
            return ['type' => 'success', 'title' => 'Success!', 'message' => 'New user has been created successfully.'];
        }

        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'New user creation has been failed.'];
    }

    public function edit(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Edit User :: Academy Management',
            'page_header' => 'Edit User',
            'page_desc' => '',
            'roles' => \Auth::user()->canDo('manage_admin') ? \App\Role::all() : \App\Role::where('id', '!=', 1)->get(), // to be changed next time with custom method,
            'user'  => User::find($id)
        ];

//        dd($data['user']->role()->id);
        return view('users.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }

        if ($request->password) {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,id'.$request->id,
                'username' => 'required|unique:users,id'.$request->id,
                'role' => 'required',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
                'status' => 'required'
            ];
        }
        else {
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
            ];
        }

        $this->validate($request, $rules);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->status = $request->status;
        $user->updated_by = \Auth::user()->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        if ($user->save()) {
            if($request->role != $user->role()->id) {
                $user->detachRole($user->role()->id);
                $user->attachRole($request->role);
            }
            return ['type' => 'success', 'title' => 'Success!', 'message' => 'The User has been updated successfully.'];
        }

        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong !'];
    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $users = User::find($id);
        $users->deleted_by = \Auth::user()->email;
        $users->save();
        if ($users->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'The User has been deleted successfully.'];
        }
    }

    public function profile($id)
    {
        $role = Auth::user()->role();

        $data = [
            'page_title' => 'Profile :: Jannat Restaurant & Resort',
            'page_header' => $role->display_name. ' Profile',
            'page_desc' => '',


        ];

//        dd($data['user']->role()->id);
        return view('users.profile')->with(array_merge($this->data, $data));
    }

    //change password

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $this->validate($request, [
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }

    //for search button

    public function searchlist(Request $request)
    {

        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        if($request->user_search) {
            $user = User::where('name', 'like', '%'.$request->user_search.'%')
                ->orWhere('email', 'like', '%'.$request->user_search.'%')
                ->orWhere('username', 'like', '%'.$request->user_search.'%')
                ->paginate(5);
        }
        $data = [
            'page_title' => 'Users List :: Academy Management',
            'page_header' => 'Users List',
            'page_desc' => '',
            'users' => $user,
        ];

        return view('users.index')->with(array_merge($this->data, $data));

    }





}