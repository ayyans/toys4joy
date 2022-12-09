<?php

namespace App\Http\Controllers\Website;

use App\Events\OrderPlaced;
use App\Helpers\Cmf;
use App\Http\Controllers\Controller;
use App\Models\giftcards;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request) {
        if (cart()->getSubTotal() == 0) {
            return redirect()->route('website.home');
        }

        $items = cart()->getContent();
        $order_number = generateOrderNumber();
        $address_id = auth()->check() ? auth()->user()->address->id : null;
        $order_type = $request->order_type;
        $is_abandoned = $order_type === 'cc';

        DB::beginTransaction();

        // order details
        $orderDetails = [
            'user_id' => auth()->id(),
            'order_number' => $order_number,
            'address_id' => $address_id,
            'order_type' => $order_type,
            'subtotal' => cart()->getSubTotal(),
            'discount' => cart()->getSubTotal() - cart()->getTotal(),
            'total_amount' => cart()->getTotal(),
            'payment_status' => 'unpaid',
            'order_status' => 'placed',
            'transaction_number' => null,
            'additional_details->is_abandoned' => $is_abandoned,
            'additional_details->is_new' => true
        ];
        // if it's guest
        if (auth()->guest()) {
            $orderDetails = array_merge($orderDetails, [
                'additional_details->name' => $request->custname,
                'additional_details->email' => $request->email,
                'additional_details->mobile' => $request->mobile,
                'additional_details->unit_no' => $request->unit_no,
                'additional_details->building_no' => $request->building_no,
                'additional_details->zone' => $request->zone,
                'additional_details->street' => $request->street
            ]);
        }

        // creating order
        $order = Order::create($orderDetails);
        // creating order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->associatedModel['unit_price'],
                'quantity' => $item->quantity,
                'discount' => $item->associatedModel['unit_price'] - $item->price,
                'total_amount' => $item->getPriceSum()
            ]);
        }

        DB::commit();

        // attach giftcards to order
        $giftCardIds = cart()->getConditionsByType('giftcard')->map(function($g) {
            return $g->getAttributes()['id'];
        })->values();
        if ($giftCardIds) {
            giftcards::whereIn('id', $giftCardIds)->update([
                'user_id' => auth()->id(),
                'order_id' => $order->id
            ]);
        }

        if ($order_type == 'cod') {
            // attach used coupon to order
            $coupon_id = cart()->getConditionsByType('coupon')->first();
            if ($coupon_id) {
                $coupon_id = $coupon_id->getAttributes()['id'];
                $order = Order::where('order_number', $order_number)->first();
                $order->update([
                    'coupon_id' => $coupon_id
                ]);
            }
            // clearing cart
            cart()->clear();
            cart()->clearCartConditions();
            // forget session
            session()->forget('order_number');

            event(new OrderPlaced($order));
            Cmf::sendordersms($order->order_number);

            return view('website.guestthanks', compact('order_number'));
        }

        // for testing confirmOrder directly
        // return self::confirmOrder($request->merge([
        //     'STATUS' => 'TXN_SUCCESS',
        //     'ORDERID' => $order_number,
        //     'transaction_number' => random_int(110, 999)
        // ]));

        $form = generateSadadForm($items, route('website.confirm-order'));

        return view('website.sadad-checkout', compact('form'));
    }

    public function confirmOrder(Request $request) {
        $data =  $request->all();

        $status = $data['STATUS'];

        if ($status != 'TXN_SUCCESS') {
            $redirect = auth()->check()
                ? redirect()->route('website.payasmember')
                : redirect()->route('website.payasguest');
            return $redirect->with('error','Payment failed!');
        }

        $order_number = $data['ORDERID'];
        $transaction_number = $data['transaction_number'];

        $coupon_id = cart()->getConditionsByType('coupon')->first();
        if ($coupon_id) {
            $coupon_id = $coupon_id->getAttributes()['id'];
        }

        $order = Order::where('order_number', $order_number)->first();
        $order->update([
            'coupon_id' => $coupon_id,
            'payment_status' => 'paid',
            'transaction_number' => $transaction_number,
            'additional_details->is_abandoned' => false,
        ]);

        $giftCardIds = cart()->getConditionsByType('giftcard')->map(function($g) {
            return $g->getAttributes()['id'];
        })->values();

        giftcards::whereIn('id', $giftCardIds)->update([
            'user_id' => auth()->id(),
            'order_id' => $order->id
        ]);

        // clearing cart
        cart()->clear();
        cart()->clearCartConditions();
        // forget session
        session()->forget('order_number');

        event(new OrderPlaced($order));
        Cmf::sendordersms($order->order_number);

        return view('website.guestthanks', compact('order_number'));
    }
}
