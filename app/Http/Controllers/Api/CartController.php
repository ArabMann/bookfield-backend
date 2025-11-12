<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCartRequest;

class CartController extends Controller
{
    //
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        if (Auth::check() && Auth::user()->role->name !== "Customer" && !Auth::user()->carts()->where("user_id", Auth::id())->exists()) {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan pemiliki Data Cart Ini"
            ]);
        }

        $carts = $this->cartService->getAll();
        $totalAmount = $carts->sum('price');
        return (CartResource::collection($carts))->additional([
            "success" => true,
            "message" => "Data Cart Berhasil Ditampilkan",
            "total_amount" => $totalAmount,
        ]);
    }

    public function store(StoreCartRequest $request)
    {
        $start = microtime(true);

        if (Auth::check() && Auth::user()->role->name !== "Customer") {
            return response()->json([
                "success" => false,
                "message" => "Anda Tidak Dapat Menambahkan Data Kedalam Cart",
            ]);
        }

        $validation = $request->validated();

        // ukur waktu khusus storeCart
        $cartStart = microtime(true);
        $cart = $this->cartService->storeCart($validation);
        $cartEnd = microtime(true);

        $end = microtime(true);

        Log::info("StoreCart() execution: " . round(($cartEnd - $cartStart) * 1000, 2) . " ms");
        Log::info("Total request execution: " . round(($end - $start) * 1000, 2) . " ms");

        return (new CartResource($cart))->additional([
            "success" => true,
            "message" => "Data Cart Berhasil ditambahkan"
        ]);
    }


    public function destroy(Cart $cart)
    {
        return $this->cartService->deleteCart($cart);
    }
}
