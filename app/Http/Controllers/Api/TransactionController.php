<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Cart;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function checkout(){
        // $validation = $request->validated();
        $user = Auth::user();
        
        $carts = Cart::with(["field", "schedule", "day"])->where("user_id", $user->id)->get();

        $token = $this->paymentService->createTransaction($carts, $user);

        return response()->json([
            "success" =>true,
            "message" => "Berhasil",
            "token" => $token,
        ]);
    }
}
