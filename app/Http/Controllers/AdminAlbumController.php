<?php
namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Support\Facades\Auth;

class AdminAlbumController extends Controller
{
    public function index()
    {
        // Haal alle albums op
        $albums = Album::with('user')->get(); // Veronderstellend dat Album een relatie heeft met User

        return view('admin.index', compact('albums'));
    }

    public function toggleStatus(Album $album)
    {
        \Log::info("Toggling status for Album ID: {$album->id}, Current Status: {$album->is_active}");
        $album->is_active = !$album->is_active;
        $album->save();

        \Log::info("New Status for Album ID: {$album->id} is now: {$album->is_active}");

        return redirect()->route('admin.albums')->with('success', 'Album status bijgewerkt.');
    }

    public function destroy(Album $album)
    {
        // Controleer of de ingelogde gebruiker de eigenaar is van het album of een admin
        if ($album->user_id === Auth::id() || Auth::user()->status == 1) {  // Dit zou goed moeten werken voor admins.
            $album->delete();
            return redirect()->route('admin.albums')->with('success', 'Album verwijderd!');
        }


        return redirect()->route('albums.index')->with('error', 'Je hebt geen rechten om dit album te verwijderen.');
    }

}
