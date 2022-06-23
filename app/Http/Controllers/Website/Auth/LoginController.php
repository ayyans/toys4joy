<?php

namespace App\Http\Controllers\Website\Auth;
use Auth;
use App\Models\Customer;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    //
     //
     public function __construct(){ 

        $categoriestest = Category::where('status','=','2')->orderBy('id','desc')->get();
        View::share('categoriestest', $categoriestest);
        
    }

     public function login(){
        return view('website.auth.login');
    }

    public function login_process(Request $request)
    {
        $data = $request->all();
        $this->validator($request);
        if(auth()->attempt(['email'=>$data['email'],'password'=>$data['password']],$request->filled('remember'))){

        if(Auth::user()->status == 1)
        {
            return redirect()->route('website.otp')->with('warning','Please Enter Code!');
        }
        return redirect()->intended('/')->with('success','You are Logged in as customer!');
        }
    
        //Authentication failed...
        return $this->loginFailed();
    }

    /**
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
      Auth::logout();
      return redirect()->route('website.login')->with('success','customer has been logged out!');
    }

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request)
    {
      //validate the form...

              //validation rules.
    $rules = [
        'email'    => 'required|email|exists:customers|min:5|max:191',
        'password' => 'required|string|min:4|max:255',
    ];

    //custom validation error messages.
    $messages = [
        'email.exists' => 'These credentials do not match our records.',
    ];

    //validate the request.
    $request->validate($rules,$messages);

    }

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
      //Login failed...

      return redirect()
      ->back()
      ->withInput()
      ->with('error','Login failed, please try again!');
    }
}
