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
        $items = cart()->getContent();
        $user = null;
        if (auth()->check()) {
            $user = auth()->user()->load('address');
        }

        $order_number = generateOrderNumber();
        $user_id = $user ? $user->id : null;
        $address_id = $user ? $user->address->id : null;
        $order_type = $request->order_type;

        DB::beginTransaction();

        // order details
        $orderDetails = [
            'user_id' => $user_id,
            'order_number' => $order_number,
            'address_id' => $address_id,
            'order_type' => $order_type,
            'subtotal' => cart()->getSubTotal(),
            'discount' => cart()->getSubTotal() - cart()->getTotal(),
            'total_amount' => cart()->getTotal(),
            'payment_status' => 'unpaid',
            'order_status' => 'placed',
            'transaction_number' => null,
            'additional_details->is_new' => true
        ];
        // if it's guest
        if (auth()->guest()) {
            $orderDetails = array_merge($orderDetails, [
                'additional_details->name' => $request->custname,
                'additional_details->email' => $request->email,
                'additional_details->mobile' => $request->mobilenumber
            ]);
        }

        // creating order
        $order = Order::create($orderDetails);
        // creating order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->associatedModel->unit_price,
                'quantity' => $item->quantity,
                'discount' => $item->associatedModel->unit_price - $item->price,
                'total_amount' => $item->getPriceSum()
            ]);
        }

        DB::commit();

        // event(new OrderPlaced($order));
        // Cmf::sendordersms($order->order_number);

        if ($order_type == 'cod') {
            // clearing cart
            cart()->clear();
            cart()->clearCartConditions();
            // forget session
            session()->forget('order_number');
            // attach used coupon to order
            $coupon_id = cart()->getConditionsByType('coupon')->first();
            if ($coupon_id) {
                $coupon_id = $coupon_id->getAttributes()['id'];
                $order = Order::where('order_number', $order_number)->first();
                $order->update([
                    'coupon_id' => $coupon_id
                ]);
            }
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
        }

        return response()->json([
            'status' => true,
            'order_number' => $order_number
        ]);
    }
}
