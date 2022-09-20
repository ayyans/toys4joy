<?php

namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\View;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    //
    public function __construct()
    {

        $categoriestest = Category::where('status', '=', '2')->orderBy('id', 'desc')->get();
        View::share('categoriestest', $categoriestest);
    }

    public function register()
    {
        return view('website.auth.register');
    }

    // private function sendMessage($message, $recipients)
    // {
    //     $account_sid = getenv("TWILIO_SID");
    //     $auth_token = getenv("TWILIO_AUTH_TOKEN");
    //     $twilio_number = getenv("TWILIO_NUMBER");
    //     $client = new Client($account_sid, $auth_token);
    //     $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    // }
    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
        // $otp=rand('132456' , '654321');
        // $mobile_with_code = $request->countrycode . $request->phone;
        $savecustomers = new User;
        $savecustomers->name = $request->name;
        $savecustomers->email = $request->email;
        $savecustomers->mobile = $request->mobilenumber;
        $savecustomers->status = 1;
        $savecustomers->type = 'customer';
        // $savecustomers->otp = $otp;
        $savecustomers->password = Hash::make($request->password);
        $savecustomers->show_password = $request->password;
        $savecustomers->save();
        // $this->sendMessage('Your One Time Pin Is '.$otp.'. Use this Pin for Verification On TOYS 4 JOY.', $request->mobilenumber);
        sendOTPCode($savecustomers->mobile, 'register');
        // Auth::login($savecustomers);
        return redirect()->route('website.otp')
            ->with('warning', 'Please Enter Code!')
            ->with('mobile', $savecustomers->mobile);
    }
}
