<?php

namespace App\Http\Controllers\Admin\Auth;
use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    //

    public function login(){
        return view('admin.auth.login');
    }

    public function login_process(Request $request)
    {
        //Validation...
        
        //Login the admin...
        
        //Redirect the admin...
        // $request->only('email','password')
        $data = $request->all();
           
        $this->validator($request);
    
        if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']],$request->filled('remember'))){
            //Authentication passed...
            return redirect()
                ->intended('admin/home')
                ->with('success','You are Logged in as admin!');
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
      //logout the admin...

      Auth::guard('admin')->logout();
      return redirect()
          ->route('admin.login')
          ->with('success','admin has been logged out!');

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
        'email'    => 'required|email|exists:users|min:5|max:191',
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
