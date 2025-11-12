<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "name", "field_id",
    ];

    public function field(){
        return $this->belongsTo(Field::class);
    }

    public function schedules(){
        return $this->hasMany(Schedule::class)->orderBy('start', "asc");
    }
}
