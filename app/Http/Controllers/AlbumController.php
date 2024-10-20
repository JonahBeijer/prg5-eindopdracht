<?php

namespace App\Http\Controllers;

use App\Models\album;
use App\Models\Genre;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $genres = Genre::all(); // Haal alle genres op

        // Controleer of er een genre is geselecteerd
        if ($request->has('genre') && !empty($request->genre)) {
            // Filter de albums op het geselecteerde genre met een geldige relatie
            $albums = Album::where('genre_id', $request->genre)->get();
        } else {
            // Haal alle albums op als er geen genre is geselecteerd
            $albums = Album::all();
        }

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
            'album_name',
            'artist_name' ,
            'genre_id' ,
            'release_date' ,
            'images' ,
        ]);

        // Controleer of het bestand aanwezig is
        if ($request->hasFile('images')) {
            // Afbeelding opslaan
            $imagePath = $request->file('images')->store('images/albums', 'public'); // Sla de afbeelding op in de 'public/images/albums' map

            // Album aanmaken
            Album::create([
                'album_name' => $request->input('album_name'),
                'artist_name' => $request->input('artist_name'),
                'genre_id' => $request->input('genre_id'),
                'release_date' => $request->input('release_date'),
                'images' => $imagePath, // Sla het pad op in de database
            ]);

            return redirect()->route('albums.index')->with('success', 'Album toegevoegd!');
        } else {
            return back()->withErrors(['images' => 'Er is geen afbeelding geüpload.']);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }


}
