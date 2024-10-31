<?php

namespace App\Http\Controllers;

use App\Models\album; // Zorg ervoor dat je de modelnaam correct schrijft
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Album $album) // Gebruik Album met een hoofdletter
    {
        $request->validate([
            'content' => 'required|string|max:500', // Voeg een maximale lengte toe
        ]);

        // Controleer of de gebruiker minstens 3 albumposts heeft gemaakt
        $postCount = album::where('users_id', Auth::id())->count(); // Gebruik Album in plaats van album


        if ($postCount < 3) {
            return redirect()->back()->withErrors(['message' => 'Je moet minimaal 3 albumposts hebben gemaakt voordat je een reactie kunt plaatsen.']);
        }

        // Maak de comment aan en koppel deze aan het album en de ingelogde gebruiker
        $comment = $album->comments()->create([
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
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
            'content' => 'required|string|max:500', // Zorg voor dezelfde validatie
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
