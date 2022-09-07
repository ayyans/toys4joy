<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\adminsmsnumbers;
use App\Models\GuestOrder;
use App\Models\Order;
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
    public static function sendordersms($order_number)
    {
        $adminNumbers = adminsmsnumbers::all();
        $order = Order::with('user')->where('order_number', $order_number)->first();
        $name = $order->user_id ? $order->user->name : $order->additional_details['name'];

        // $checkorder = Order::where('orderid', $orderid)->get()->count();
        // if ($checkorder > 0) {
        //     $order = Order::where('orderid', $orderid)->get()->first();
        //     $user = DB::table('users')->where('id', $order->cust_id)->get()->first();
        //     $name = $user->name;
        // } else {
        //     $order = GuestOrder::where('order_id', $orderid)->get()->first();
        //     $name = $order->cust_name;
        // }

        foreach ($adminNumbers as $adminNumber) {
            $message = "Hi! $name Placed New Order. Order ID $order_number";
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($adminNumber->number, ['from' => $twilio_number, 'body' => $message]);
        }
    }
    public static function ipaddress()
    {
        if (session()->get('cart') > 0) {
            return session()->get('cart');
        } else {
            $cartnumber = rand('123456789987654321', '987654123123456789');
            session()->put('cart', $cartnumber);
            return session()->get('cart');
        }
    }
    public static function sendimagetodirectory($imagename)
    {
        if (!$imagename) return;
        $file = $imagename;
        $filename = rand() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
        return $filename;
    }
}
