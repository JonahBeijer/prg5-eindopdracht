<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Albums</title>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('albums.index') }}">Albums</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('albums.index') }}">Alle Albums</a>
            </li>
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('albums.create') }}">Album Toevoegen</a>
                </li>
            @endauth
        </ul>

        <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item">
                    <span class="navbar-text">Welkom, {{ Auth::user()->name }}</span>
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
            @endauth
        </ul>
    </div>
</nav>

<body>
<div class="container mt-4">
    <a href="{{ route('albums.index') }}" class="text-decoration-none">
        <h1 class="text-center">Albums</h1>
    </a>

    <form method="GET" action="{{ route('albums.index') }}" class="mb-4">
        <div class="form-row align-items-end">
            <div class="col-auto">
                <label for="genre">Filter op genre:</label>
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
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <form method="GET" action="{{ route('albums.index') }}" class="mb-4">
        <div class="form-row align-items-end">
            <div class="col-auto">
                <input type="text" name="search" placeholder="Zoek naar albums of artiesten" value="{{ request('search') }}" class="form-control">
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
                    <img src="{{ asset('storage/' . $album->images) }}" class="card-img-top" alt="{{ $album->album_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $album->album_name }}</h5>
                        <p class="card-text"><strong>Artiest:</strong> {{ $album->artist_name }}</p>
                        <p class="card-text"><small> {{ $album->user->name }}</small></p>
                        <a href="{{ route('albums.show', $album->id) }}" class="btn btn-info">Bekijk Details</a>
                        @if (Auth::check() && ($album->users_id === Auth::id() || Auth::user()->status == 1))
                            <a href="{{ route('albums.edit', $album->id) }}" class="btn btn-warning">Bewerken</a>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


</body>
</html>
