<?php

namespace App\Services;

use Exception;
use App\Models\Cart;
use App\Models\Schedule;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getAll()
    {

        $user = Auth::user();
        $carts = Cart::with(['field', 'schedule', 'day'])
            ->where('user_id', $user->id)
            ->get();

        return $carts;
    }

    public function storeCart(array $data)
    {
        $start = microtime(true);

        $user = Auth::user();

        // Step 1: cek cart
        $step1 = microtime(true);
        $cart = Cart::where("user_id", $user->id)
            ->where("schedule_id", $data["schedule_id"])
            ->first();
        Log::info("Step 1 (cek cart): " . round((microtime(true) - $step1) * 1000, 2) . " ms");

        // Step 2: ambil schedule
        $step2 = microtime(true);
        $schedule = Schedule::findOrFail($data["schedule_id"]);
        Log::info("Step 2 (ambil schedule): " . round((microtime(true) - $step2) * 1000, 2) . " ms");

        $data['user_id'] = $user->id;
        $data["price"] = $schedule->price;

        // Step 3: jika sudah ada
        if ($cart) {
            Log::info("Step 3 (cart sudah ada): " . round((microtime(true) - $start) * 1000, 2) . " ms");
            return response()->json([
                "success" => true,
                "message" => "Data pada Cart sudah ada"
            ]);
        }

        // Step 4: insert cart baru
        $step4 = microtime(true);
        $cart = Cart::create($data);
        Log::info("Step 4 (insert cart): " . round((microtime(true) - $step4) * 1000, 2) . " ms");

        Log::info("Total storeCart(): " . round((microtime(true) - $start) * 1000, 2) . " ms");

        return $cart;
    }


    public function deleteCart($cart)
    {
        if (Auth::check() && Auth::user()->role->name !== "Customer" && $cart->user_id !== Auth::id()) {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Pemilik Cart Jadi Tidak Dapat Menghapus Data Cart"
            ]);
        }

        DB::beginTransaction();
        try {
            $cart->delete();
            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data Cart Berhasil dihapus"
            ]);
        } catch (Exception) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => "Data Cart Tidak Berhasil dihapus"
            ]);
        }
    }
}
