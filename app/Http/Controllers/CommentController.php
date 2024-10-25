<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Album $album)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

// Maak de comment aan en koppel deze aan het album en de ingelogde gebruiker
        $comment = $album->comments()->create([
            'content' => $request->input('content'), // Hier gebruik je input() in plaats van direct
            'user_id' => auth()->id(),
        ]);



        return redirect()->route('albums.show', $album->id)->with('success', 'Reactie geplaatst!');
    }
}
