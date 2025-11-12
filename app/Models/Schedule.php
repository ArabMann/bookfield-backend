<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "price", "start", "end", "is_active", "day_id"
    ];

    public function day(){
        return $this->belongsTo(Day::class);
    }

}
