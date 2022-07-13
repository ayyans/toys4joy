<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\adminsmsnumbers;
use App\Models\GuestOrder;
use App\Models\order;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;
class Cmf
{
    public static function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    }
    public static function sendordersms($orderid)
    {
        $data = adminsmsnumbers::all();
        $checkorder = order::where('orderid' , $orderid)->get()->count();
        if($checkorder > 0)
        {
            $order = order::where('orderid' , $orderid)->get()->first();
            $user = DB::table('users')->where('id' , $order->cust_id)->get()->first();
            $name = $user->name;
        }
        else
        {
            $order = GuestOrder::where('order_id' , $orderid)->get()->first();
            $name = $order->cust_name;
        }
        foreach ($data as $r) {
            $message = 'Hi! 
'.$name.' Placed New Order. 
Order ID '.$orderid.'';
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($r->number, ['from' => $twilio_number, 'body' => $message]);
        }
    }
    public static function ipaddress(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    public static function sendimagetodirectory($imagename)
    {
        $file = $imagename;
        $filename = rand() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
        return $filename;
    } 
}
