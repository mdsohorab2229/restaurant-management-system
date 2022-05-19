<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * find username or email
     *
     * @return string
     */
    public function username()
    {
        if(filter_var(request()->email, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }else{
            return 'username';
        }
    }

    /**
     * login validtion
     *
     * @return string
     */
    public function loginValidation(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
    }

    /**
     * attempt login with username or email 
     *
     * @return void
     */
    public function login(Request $request)
    {
       $this->loginValidation($request);
        
        //attempt login with usename or email
        Auth::attempt([$this->username() => $request->email, 'password' => $request->password]);
        
        //was any of those correct ?
        if ( Auth::check()) {
            //send them where they are going
            if(Auth::user()->hasRole('waiter')){
                return redirect('/waiter');
            }
            else if(Auth::user()->hasRole('super_admin')) {
                return redirect()->intended('/');
            }
            
            return redirect()->intended('/');
            
        }

        //Nope, something wrong during authentication 
        return redirect()->back()->withErrors([
            'credentials' => 'Invalid Credential'
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->forget(['get_sound', 'previous_orders', 'total_orders']);

        return redirect('/');
    }


}
