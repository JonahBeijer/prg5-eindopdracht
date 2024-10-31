@include('layouts.navbar')


<div class="container mt-4">
    <h1 class="mb-4">Album Bewerken: {{ $album->album_name }}</h1>

    <form id="updateAlbumForm" action="{{ route('albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="album_name">Album Naam:</label>
            <input type="text" id="album_name" name="album_name" value="{{ old('album_name', $album->album_name) }}" required class="form-control">
            @error('album_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="artist_name">Artiest Naam:</label>
            <input type="text" id="artist_name" name="artist_name" value="{{ old('artist_name', $album->artist_name) }}" required class="form-control">
            @error('artist_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="genre_id">Genre:</label>
            <select name="genre_id" id="genre_id" required class="form-control">
                <option value="">Selecteer een genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ (old('genre_id', $album->genre_id) == $genre->id) ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
            @error('genre_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="release_date">Release Datum:</label>
            <input type="date" id="release_date" name="release_date" value="{{ old('release_date', $album->release_date) }}" required class="form-control">
            @error('release_date')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
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
            @error('images')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="caption">Caption:</label>
            <input type="text" id="caption" name="caption" value="{{ old('caption', $album->caption) }}" required class="form-control">
            @error('caption')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </form>

    <div class="d-flex mt-3">
        <button type="submit" class="knop" onclick="disableButton(this)">Update Album</button>

        <form action="{{ route(Auth::user()->status == 1 ? 'albums.admin.destroy' : 'albums.user.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit album wilt verwijderen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="knop">Verwijder Album</button>
        </form>
    </div>

</div>
</body>
<script>
    function disableButton(button) {
        button.disabled = true;
        button.innerText = 'Verwerken...';
        document.getElementById('updateAlbumForm').submit();
    }
</script>

</html>
