<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Album Details</title>
</head>
<body>
<div class="container mt-4">
    <a href="{{ route('albums.index') }}" class="text-decoration-none">
        <h1 class="text-center">Album Details</h1>
    </a>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <img src="{{ asset('storage/' . $album->images) }}" class="card-img-top" alt="{{ $album->album_name }}" style="width: 50%; height: auto;">
                <div class="card-body">
                    <h5 class="card-title">{{ $album->album_name }}</h5>
                    <p class="card-text"><strong>Artiest:</strong> {{ $album->artist_name }}</p>
                    <p class="card-text"><strong>Genre:</strong> {{ $album->genre ? $album->genre->name : 'Geen genre gevonden' }}</p>
                    <p class="card-text"><strong>Release Datum:</strong> {{ date('d-m-Y', strtotime($album->release_date)) }}</p>
                    <p class="card-text"><small> {{ $album->user->name }}</small></p>
                    @if (Auth::check() && ($album->users_id === Auth::id() || Auth::user()->status == 1))
                        <a href="{{ route('albums.edit', $album->id) }}" class="btn btn-warning">Bewerken</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
