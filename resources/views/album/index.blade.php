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

<body>
<div class="container mt-4">


    <form method="GET" action="{{ route('albums.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-auto">
                <select name="genre" id="genre" class="form-control">
                    <option value="">Selecteer een genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="knop">Filter</button>
            </div>
            <div class="col">
                <input type="text" name="search" placeholder="Zoek naar albums, artiesten of gebruikers" value="{{ request('search') }}" class="form-control">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Zoeken</button>
            </div>
        </div>
    </form>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($albums as $album)
            <div class="col mb-3">
                <div class="card h-100">
                    <p class="card-text">
                        <small class="proffoto d-flex align-items-center" style="margin-bottom: -10px;"> <!-- Negatieve marge naar beneden -->
                            @if ($album->user)
                                <img src="{{ $album->user->profile_image ? asset('storage/profile_images/' . $album->user->profile_image) : asset('storage/profile_images/default.webp') }}"
                                     alt="Profielafbeelding"
                                     class="img-fluid rounded-circle"
                                     style="width: 30px; height: 30px; margin-right: 7px; margin-top: 5px; margin-bottom: -3px;">
                                <span class="font-weight-bold" style="color: #333; margin-top: 10px; margin-right: 7px;">{{ $album->user->name }}</span>
                            @endif
                        </small>

                    </p>
                    <img src="{{ asset('storage/' . $album->images) }}" class="card-img-top" alt="{{ $album->album_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $album->album_name }}</h5>
                        <p class="card-text"><strong>Artiest:</strong> {{ $album->artist_name }}</p>
                        <a href="{{ route('albums.show', $album->id) }}" class="knop">Bekijk Details</a>
                        @if (Auth::check() && ($album->users_id === Auth::id() || Auth::user()->status == 1))
                            <a href="{{ route('albums.edit', $album->id) }}" class="knop">Bewerken</a>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


</body>
</html>
