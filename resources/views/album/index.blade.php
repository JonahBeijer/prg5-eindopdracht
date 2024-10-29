

    @include('layouts.navbar') <!-- Dit voegt de navigatiebalk toe -->

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
    </div>

