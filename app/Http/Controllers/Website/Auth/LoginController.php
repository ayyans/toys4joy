<?php

namespace App\Http\Controllers\Website\Auth;

use Auth;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __construct()
    {
        $categoriestest = Category::where('status', '=', '2')->orderBy('id', 'desc')->get();
        View::share('categoriestest', $categoriestest);
    }

    public function login()
    {
        return view('website.auth.login');
    }

    public function login_process(Request $request)
    {
        $this->validator($request);
        $user = User::firstWhere('email', $request->email);

        if ($user->status == 1) {
            sendOTPCode($user);
            return redirect()->route('website.otp')->with('warning', 'Please Enter Code!');
        }

        if ( ! auth()->login( $user, $request->filled('remember') ) ) {
            return $this->loginFailed();
        }

        return redirect()->intended('/')->with('success', 'You are Logged in as customer!');
    }
    public function verificationotp()
    {
        return view('website.verifyotp');
    }
    public function confermotp(Request $request)
    {
        $user = User::where('otp', $request->otp)->first();
        if ($user) {
            $user->forceFill(['status' => 2])->save();
            event(new Registered($user)); // Registered event fired
            auth()->login($user, true);
            return redirect()->route('website.home')->with('success', 'Your Account is Approved');
        } else {
            return back()->with('error', 'Invalid OTP');
        }
    }
    /**
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('website.login')->with('success', 'customer has been logged out!');
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
        return $request->validate($rules, $messages);
    }

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
        //Login failed...
        return redirect()->back()->withInput()->with('error', 'Login failed, please try again!');
    }

    public function forgot_password()
    {
        return view('website.auth.forgot_password');
    }

    public function send_forgot_password(Request $request)
    {
        $email = $request->email;
        $userExists = User::where('email', $email)->exists();
        if (!$userExists) {
            return redirect()->route('website.forgot_password')->with('error', 'Please enter a valid email address!');
        }
        $token = Str::random(40);
        $entry = DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);
        Mail::to($email)->send(new PasswordResetMail(['email' => $email, 'token' => $token]));
        return redirect()->route('website.forgot_password')->with('success', 'Password reset mail sent successfully!');
    }

    public function reset_password($email, $token)
    {
        $isNotValidToken = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $token)
            ->doesntExist();
        abort_if($isNotValidToken, 403);
        return view('website.auth.reset_password', compact('email', 'token'));
    }

    public function set_reset_password(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'token' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);

        User::where('email', $request->email)->update([
            'password' => bcrypt($request->password),
            'show_password' => $request->password
        ]);

        DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->delete();

        return redirect()->route('website.login')->with('success', 'Password reset successfully');
    }
}
