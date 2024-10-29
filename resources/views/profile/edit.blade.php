@include('layouts.navbar')


<div class="container mt-4">
    @auth
        <!-- Profiel Foto Upload -->
        <h3>Huidige Profielfoto:</h3>
        @if(Auth::user()->profile_image)
            <img src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}" alt="Profielafbeelding" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
        @else
            <p>Geen profielfoto geüpload.</p>
        @endif

        <form method="POST" action="{{ route('profile.image.upload') }}" enctype="multipart/form-data" class="mt-3 col-4">
            @csrf
            <div class="form-group">
                <label for="profile_image">Upload een Profielfoto:</label>
                <input type="file" id="profile_image" name="profile_image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload Profielfoto</button>
        </form>

        <!-- Gebruikersgegevens Bewerken -->
        <h3 class="mt-5">Gegevens aanpassen</h3>
        <form method="POST" action="{{ route('profile.update') }}" class="col-4">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">E-mailadres:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
            </div>
            <button type="submit" class="btn btn-success">Gegevens Opslaan</button>
        </form>

        <!-- Wachtwoord Wijzigen -->
        <h3 class="mt-5">Wachtwoord aanpassen</h3>
        <form method="POST" action="{{ route('password.update') }}" class="col-4">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="current_password">Huidig Wachtwoord:</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Nieuw Wachtwoord:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Bevestig Nieuw Wachtwoord:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning">Wachtwoord Opslaan</button>
        </form>
    @endauth
</div>
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $user->name }}'s Profiel</h1>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @if($albums->isEmpty())
                <p>Je hebt nog geen albums toegevoegd.</p>
            @else
                @foreach ($albums as $album)
                    <div class="col mb-3">
                        <div class="card h-100">
                            <p class="card-text">
                                <small class="proffoto d-flex align-items-center" style="margin-bottom: -10px;">
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
                                @php
                                    $words = explode(' ', $album->caption);
                                    $truncated = implode(' ', array_slice($words, 0, 7));
                                @endphp
                                <p class="card-text">{{ $truncated }}{{ count($words) > 7 ? '...' : '' }}</p>
                                <a href="{{ route('albums.show', $album->id) }}" class="knop">Bekijk post</a>
                                @if (Auth::check() && ($album->users_id === Auth::id() || Auth::user()->status == 1))
                                    <a href="{{ route('albums.edit', $album->id) }}" class="knop">Bewerken</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @endsection

</body>
</html>
