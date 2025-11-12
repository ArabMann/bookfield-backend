<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "name",
        "image",
        "description",
        "room_id",
        "category_id",
        "slug",
    ];

    // Ini mengubah bawaan yang awalnya menggunakan ID menjadi slug

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function days()
    {
        return $this->hasMany(Day::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
