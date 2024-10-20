<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class album extends Model
{
    protected $fillable = [
        'album_name',
        'artist_name',
        'genre_id',
        'release_date',
        'images',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}



