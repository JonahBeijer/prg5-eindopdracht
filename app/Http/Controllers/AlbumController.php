<?php

namespace App\Http\Controllers;
use App\Models\album;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $genres = Genre::all();
        $searchTerm = $request->input('search');


        $albumsQuery = Album::with('user', 'genre');

        if ($searchTerm) {
            $albumsQuery->where(function ($query) use ($searchTerm) {
                $query->where('album_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('artist_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }


        if ($request->has('genre') && !empty($request->genre)) {
            $albumsQuery->where('genre_id', $request->genre);
        }

        $albums = $albumsQuery->where('is_active', 1)->get();

        return view('album.index', compact('genres', 'albums'));
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        return view('albums.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'album_name' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'genre_id' => 'required|integer',
            'release_date' => 'required|date',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif',
            'caption' => 'required|string|max:255',
        ], [
            'album_name.required' => 'Je moet een album naam invoeren.',
            'artist_name.required' => 'Je moet een artiest naam invoeren.',
            'genre_id.required' => 'Selecteer een genre.',
            'release_date.required' => 'Voer een release datum in.',
            'images.required' => 'Een afbeelding is verplicht.',
            'images.image' => 'De afbeelding moet een geldig afbeeldingsformaat zijn.',
            'caption.required' => 'Voer een caption in.',
        ]);



        // Controleer of het bestand aanwezig is
        if ($request->hasFile('images')) {

            $imagePath = $request->file('images')->store('images/albums', 'public');

            $albums = Album::with('user', 'genre')->get(); // Voeg ook genre toe als dat nodig is


            // Album aanmaken
            Album::create([
                'album_name' => $request->input('album_name'),
                'artist_name' => $request->input('artist_name'),
                'genre_id' => $request->input('genre_id'),
                'release_date' => $request->input('release_date'),
                'images' => $imagePath, // Sla het pad op in de database
                'users_id' => Auth::id(), // Dit geeft de ingelogde gebruikers ID
                'caption' => $request->input('caption'),

            ]);

            return redirect()->route('albums.index')->with('success', 'Album toegevoegd!');
        } else {
            return back()->withErrors(['images' => 'Er is geen afbeelding geüpload.']);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $album = Album::with('user', 'genre')->find($id);

        // Controleer of het album bestaat
        if (!$album) {
            return redirect()->route('albums.index')->with('error', 'Album niet gevonden.');
        }

        return view('albums.show', compact('album'));
    }



    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $album = Album::findOrFail($id);
        $genres = Genre::all();


        if ($album->users_id !== Auth::id() && Auth::user()->status != 1) {
            return redirect()->route('albums.index')->with('error', 'Je hebt geen toegang om dit album te bewerken.');
        }

        return view('albums.edit', compact('album', 'genres')); // Geef album en genres door naar de view
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is of een admin
        if ($album->users_id !== Auth::id() && Auth::user()->status != 1) {
            return redirect()->route('albums.index')->with('error', 'Je hebt geen rechten om dit album te bewerken.');
        }

        // Validatie
        $request->validate([
            'album_name' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'genre_id' => 'required|integer',
            'release_date' => 'required|date',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Maak afbeeldingen optioneel
            'caption' => 'required|string|max:255',
        ], [
            'album_name.required' => 'Je moet een album naam invoeren.',
            'artist_name.required' => 'Je moet een artiest naam invoeren.',
            'genre_id.required' => 'Selecteer een genre.',
            'release_date.required' => 'Voer een release datum in.',
            'caption.required' => 'Voer een caption in.',
            'images.image' => 'De afbeelding moet een geldig afbeeldingsformaat zijn.',

        ]);

        // Bewaar het oude afbeeldingspad
        $imagePath = $album->images;

        // Controleer of er een nieuwe afbeelding is geüpload
        if ($request->hasFile('images')) {
            // Sla de nieuwe afbeelding op
            $imagePath = $request->file('images')->store('images/albums', 'public');
        }

        // Update het album met de nieuwe gegevens
        $album->update([
            'album_name' => $request->album_name,
            'artist_name' => $request->artist_name,
            'genre_id' => $request->genre_id,
            'release_date' => $request->release_date,
            'images' => $imagePath, // Bewaar nieuwe afbeelding of behoud de oude
            'caption' => $request->input('caption'),
        ]);

        return redirect()->route('albums.index')->with('success', 'Album bijgewerkt.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $album = Album::findOrFail($id);

        if ($album->users_id === Auth::id()) {
            $album->delete();
            return redirect()->route('profile.edit')->with('success', 'Album succesvol verwijderd.');
        }


        return redirect()->route('albums.index')->with('error', 'Je hebt geen rechten om dit album te verwijderen.');
    }


    public function showRecentAlbum()
    {
        $album = Album::latest()->first();
        return view('welcome', compact('album'));
    }

}
