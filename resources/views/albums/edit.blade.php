<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Zorg ervoor dat het bestand in public/css staat -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>SpinShare</title>


</head>
<nav class="navbar navbar-expand-lg navbar-light  bg-white shadow-sm">
    <img src="{{ asset('storage/images/logo spinshare.png') }}" alt="SpinShare Logo" style="width: 150px; height: auto;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('albums.index') }}">Albums</a>
            </li>
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('albums.create') }}">Post</a>
                </li>
            @endauth
        </ul>

        <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item">
                    <img src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('storage/profile_images/default.webp') }}"
                         alt="Profielafbeelding"
                         class="rounded-circle"
                         style="width: 30px; height: 30px; margin-right: 8px;">
                    <span class="navbar-text">{{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="display:inline; cursor: pointer;">Uitloggen</button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Inloggen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>
<div class="container mt-4">
    <h1 class="mb-4">Album Bewerken: {{ $album->album_name }}</h1>

    <form action="{{ route('albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="album_name">Album Naam:</label>
            <input type="text" id="album_name" name="album_name" value="{{ $album->album_name }}" required class="form-control">
        </div>
        <div class="form-group">
            <label for="artist_name">Artiest Naam:</label>
            <input type="text" id="artist_name" name="artist_name" value="{{ $album->artist_name }}" required class="form-control">
        </div>
        <div class="form-group">
            <label for="genre_id">Genre:</label>
            <select name="genre_id" id="genre_id" required class="form-control">
                <option value="">Selecteer een genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ $genre->id == $album->genre_id ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="release_date">Release Datum:</label>
            <input type="date" id="release_date" name="release_date" value="{{ $album->release_date }}" required class="form-control">
        </div>
        <div class="form-group">
            <label for="images">Afbeelding:</label>
            <input type="file" id="images" name="images" accept="image/*" class="form-control">

            @if($album->images)
                <div class="mt-2">
                    <p>Huidige afbeelding:</p>
                    <img src="{{ asset('storage/' . $album->images) }}" alt="{{ $album->album_name }}" width="150">
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="caption">Caption:</label>
            <input type="text" id="caption" name="caption" value="{{ $album->caption }}" required class="form-control">
        </div>


        <div class="d-flex justify-content  ">
            <button type="submit" class="knop">Update Album</button>

            <form action="{{ route('albums.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit album wilt verwijderen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="knop ml-2">Verwijder Album</button>
            </form>
        </div>
    </form>
</div>
</body>

</html>
