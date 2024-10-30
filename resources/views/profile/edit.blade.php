@include('layouts.navbar')

<div class="container mt-4">
    @auth
        <div class="mb-4">
            <h3 class="text-center mb-4">Huidige Profielfoto:</h3>
            <div class="text-center mb-3">
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}" alt="Profielafbeelding" class="img-fluid rounded-circle" style="width: 150px; height: 150px; border: 2px solid #007bff; box-shadow: 0 2px 10px rgba(0, 123, 255, 0.5);">
                @else
                    <p class="text-muted">Geen profielfoto geüpload.</p>
                @endif
            </div>

            <form method="POST" action="{{ route('profile.image.upload') }}" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Upload een Profielfoto:</label>
                    <input type="file" id="profile_image" name="profile_image" class="form-control" required>
                </div>
                <button type="submit" class="knop w-100">Upload Profielfoto</button>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">Formaat: JPG, PNG, of WEBP. Maximaal 2MB.</small>
            </div>
        </div>




        <div class="row">
            <!-- Gegevens Aanpassen Formulier -->
            <div class="col-md-6">
                <div class="p-4 bg-white shadow rounde">
                @include('profile.partials.update-profile-information-form')
            </div>
            </div>
            <!-- Wachtwoord Aanpassen Formulier -->
            <div class="col-md-6">
                <div class="p-4 bg-white shadow rounded">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

    @endauth
    </div>




<div class="container mt-5">
    <h3 class="text-center">Mijn Albums:</h3>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            @if ($albums->isEmpty())
                <div class="alert alert-secondary text-center" role="alert">
                    Je hebt nog geen albums geüpload. Begin met het maken van je eerste album!
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-4">
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
                </div>
            @endif
        </div>
    </div>
</div>


</body>
</html>
