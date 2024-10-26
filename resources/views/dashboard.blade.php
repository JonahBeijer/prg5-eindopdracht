<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Zorg ervoor dat het bestand in public/css staat -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>SpinShare</title>
</head>
<body>

<!-- Navigatiebalk -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="#">
        <img src="{{ asset('storage/images/logo spinshare.png') }}" alt="SpinShare Logo" style="width: 150px; height: auto;">
    </a>
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
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="cursor: pointer;">Uitloggen</button>
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
    @auth
        <h3>Huidige Profielfoto:</h3>
        @if(Auth::user()->profile_image)
            <img src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}" alt="Profielafbeelding" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
        @else
            <p>Geen profielfoto geüpload.</p>
        @endif

        <!-- Formulier voor het uploaden van de profielfoto -->
        <form method="POST" action="{{ route('profile.image.upload') }}" enctype="multipart/form-data" class="mt-3 col-4">
            @csrf
            <div class="form-group">
                <label for="profile_image">Upload een Profielfoto:</label>
                <input type="file" id="profile_image" name="profile_image" class="form-control" required>
            </div>
            <button type="submit" class="knop">Upload Profielfoto</button>
        </form>
    @endauth
</div>

</body>
</html>
