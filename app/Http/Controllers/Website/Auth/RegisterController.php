<?php

namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Customer;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\View;

class RegisterController extends Controller
{
    //
    public function __construct(){ 

        $categoriestest = Category::where('status','=','2')->orderBy('id','desc')->get();
        View::share('categoriestest', $categoriestest);
        
    }

    public function register(){
        return view('website.auth.register');
    }

    public function registerProcess(Request $request){
        $request->validate([
            'name' => 'required',            
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6',                      
        ]);

        $mobile_with_code = $request->countrycode.$request->mobile;
        $exist_customer = Customer::where('email','=',$request->email)
                          ->orwhere('mobile','=',$request->mobile_with_code)
                          ->count(); 
                          
           if($exist_customer>0){
               return back()->with('error','customer already exist');
               exit();
           }else{
               $savecustomers = new Customer;
               $savecustomers->name=$request->name;
               $savecustomers->email=$request->email;
               $savecustomers->mobile=$mobile_with_code;
               $savecustomers->status=2;
               $savecustomers->password=Hash::make($request->password);
               $savecustomers->show_password = $request->password;
              $savecustomers->save();
              if($savecustomers==true){
                  return redirect('/registration-thanks')->with('success','customer registration successfull');
                  exit();
              }else{
                return back()->with('error','something went wrong');
                  exit();
              }
           }               


    }




}
