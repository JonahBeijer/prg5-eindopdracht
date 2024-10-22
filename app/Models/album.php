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
        'users_id'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // In Album.php model
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id'); // Zorg ervoor dat de naam overeenkomt met je kolom
    }

}




