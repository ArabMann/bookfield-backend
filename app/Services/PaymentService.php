<?php

namespace App\Services;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function createTransaction($carts, $user)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $totalAmount = $carts->sum("price");

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $totalAmount,
            ),
            'customer_details' => array(
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone_number,
            ),
        );

        $this->order($user, $totalAmount, $carts, $params);

        return $snapToken = \Midtrans\Snap::getSnapToken($params);
    }

    public function order($user, $totalAmount, $carts, $params)
    {

        DB::beginTransaction();
        try {
            $order = Order::create([
                "user_id" => $user->id,
                "date_buy" => now(),
                "midtrans_order_id" => $params["transaction_details"]["order_id"],
                "total_amount" => $totalAmount,
                "status" => "Pending",
            ]);
            // dd($order);

            foreach ($carts as $cart) {
                OrderItem::create([
                    "order_id" => $order->id,
                    "price" => $cart->price,
                    "field_id" => $cart->field_id,
                    "day_id" => $cart->day_id,
                    "schedule_id" => $cart->schedule_id,
                ]);
            }

            // hapus Cart
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // tangani error
        }
    }
}
