<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(){
        $orders = Order::with("OrderItems")->get();

        return (OrderResource::collection($orders))->additional([
            "success" => true,
            "message" => "Data Order Berhasil Ditampilkan"
        ]);   
    }
}
