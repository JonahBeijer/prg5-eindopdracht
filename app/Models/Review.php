<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['album_id', 'title'];

    public function album()
    {
        return $this->belongsTo(album::class);
    }
}

