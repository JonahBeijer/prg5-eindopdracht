<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{


    protected $fillable = [
        'content', // Voeg deze regel toe
        'user_id',
        'album_id',
    ];

    // Definieer de relatie met het Album
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Definieer de relatie met de User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
