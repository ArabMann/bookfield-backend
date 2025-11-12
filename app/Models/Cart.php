<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "user_id", "schedule_id", "day_id", "price", "field_id"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
    public function day(){
        return $this->belongsTo(Day::class);
    }
    public function field(){
        return $this->belongsTo(Field::class);
    }
}
