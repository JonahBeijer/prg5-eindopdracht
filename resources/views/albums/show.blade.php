<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Album Details</title>
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
        <h1 class="text-center">Album Details</h1>
    </a>

    <div class="row row-cols-3 justify-content-center">
        <div class="col mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/' . $album->images) }}" class="card-img-top" alt="{{ $album->album_name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $album->album_name }}</h5>
                    <p class="card-text"><strong>Artiest:</strong> {{ $album->artist_name }}</p>
                    <p class="card-text"><strong>Genre:</strong> {{ $album->genre ? $album->genre->name : 'Geen genre gevonden' }}</p>
                    <p class="card-text"><strong>Release Datum:</strong> {{ date('d-m-Y', strtotime($album->release_date)) }}</p>
                    <p class="card-text"><small>{{ $album->user->name }}</small></p>
                    @if (Auth::check() && ($album->users_id === Auth::id() || Auth::user()->status == 1))
                        <a href="{{ route('albums.edit', $album->id) }}" class="btn btn-warning">Bewerken</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Comment Form -->
    <div class="comments-section">
        @auth
            <div class="comment-form card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Laat een reactie achter:</h5>
                    <form action="{{ route('comments.store', $album->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Plaats Reactie</button>
                    </form>
                </div>
            </div>
        @else
            <p><a href="{{ route('login') }}">Log in</a> om een reactie achter te laten.</p>
        @endauth

        <!-- Weergave van reacties -->
        <h3>Reacties:</h3>
        @if($album->comments->isEmpty())
            <p>Geen reacties nog.</p>
        @else
            @foreach($album->comments as $comment)
                <div class="comment mb-3 border p-3">
                    <strong>{{ $comment->user->name }}</strong> zei op {{ $comment->created_at->format('d-m-Y H:i') }}:
                    <p>{{ $comment->content }}</p>
                </div>
            @endforeach
        @endif
    </div>
</div>
</body>
</html>
