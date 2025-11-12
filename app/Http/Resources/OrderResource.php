<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user" => $this->user?->name,
            "date_buy" => $this->date_buy,
            "status" => $this->status,
            "midtrans_order_id" => $this->midtrans_order_id,
            "total_amount" => $this->total_amount,
            "order_items" => OrderItemResource::collection($this->orderItems),
        ];
    }
}
