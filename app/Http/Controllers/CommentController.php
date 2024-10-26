<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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



    public function update(Request $request, Comment $comment)
    {
        // Controleer of de ingelogde gebruiker de eigenaar is van de comment of een admin
        if ($comment->user_id !== Auth::id() && Auth::user()->status != 1) {
            return redirect()->route('albums.index')->with('error', 'Je hebt geen rechten om deze reactie te bewerken.');
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('status', 'Reactie bijgewerkt!');
    }

    public function destroy(Comment $comment)
    {
        // Controleer of de ingelogde gebruiker de eigenaar is van de comment of een admin
        if ($comment->user_id !== Auth::id() && Auth::user()->status != 1) {
            return redirect()->route('albums.index')->with('error', 'Je hebt geen rechten om deze reactie te verwijderen.');
        }

        $comment->delete();

        return redirect()->back()->with('status', 'Reactie verwijderd!');
    }


}
