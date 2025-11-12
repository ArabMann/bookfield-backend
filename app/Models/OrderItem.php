<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "order_id",
        "price",
        "field_id",
        "schedule_id",
        "day_id",
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function field(){
        return $this->belongsTo(Field::class);
    }
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
    public function day(){
        return $this->belongsTo(Day::class);
    }
}
