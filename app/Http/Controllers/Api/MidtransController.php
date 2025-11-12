<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendHistoryBookingEmail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class MidtransController extends Controller
{
    //
    public function handleNotification(Request $request)
    {
        try {
            $type = $request->payment_type;
            $orderId = $request->order_id;
            $status = $request->transaction_status;

            $va_number = "";
            $bank = "";
            $issuer = "";

            if ($type == "bank_transfer") {
                $va_number = $request->va_numbers[0]["va_number"] ?? "";
                $bank = $request->va_numbers[0]["bank"] ?? "";
            } else {
                $issuer = $request->issuer ?? "";
            }

            $order = Order::with(['orderItems.field', 'orderItems.schedule', 'orderItems.day'])
                ->where('midtrans_order_id', $orderId)
                ->first();

            Log::info("Midtrans Callback", compact('orderId', 'status', 'type', 'bank', 'issuer', 'va_number'));

            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
            }

            // Update status order
            $order->update(['status' => $status]);

            if ($status === "settlement") {
                foreach ($order->orderItems as $item) {
                    if ($item->schedule) {
                        $item->schedule->is_active = false;
                        $item->schedule->save();
                    }
                }
                // hapus cart
                Cart::where('user_id', $order->user_id)->delete();

                $user = User::find($order->user_id);
                if ($user) {
                    try {
                        Mail::to($user->email)->send(new SendHistoryBookingEmail($order));
                    } catch (\Exception $e) {
                        Log::error("Gagal kirim email: " . $e->getMessage());
                        return response()->json(['success' => true, 'message' => 'Notifikasi berhasil namun lihat kegagalan ']);
                    }
                }
            }

            return response()->json(['success' => true, 'message' => 'Notifikasi berhasil diproses']);
        } catch (\Exception $e) {
            Log::error("Error handleNotification: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Tetap balas 200 agar Midtrans tidak retry terus
            return response()->json(['success' => false, 'message' => 'Terjadi error, tapi sudah diterima'], 200);
        }
    }
}
