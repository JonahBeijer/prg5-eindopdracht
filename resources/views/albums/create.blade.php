


<form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
    <label for="album_name">Album Naam:</label>
    <input type="text" id="album_name" name="album_name" required>
    </div>
    <div class="form-group">
    <label for="artist_name">Artiest Naam:</label>
    <input type="text" id="artist_name" name="artist_name" required>
    </div>
    <div class="form-group">
        <label for="genre_id">Genre:</label>
        <select name="genre_id" id="genre_id" required>
            <option value="">Selecteer een genre</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>

    </div>
    <div class="form-group">
    <label for="release_date">Release Datum:</label>
    <input type="date" id="release_date" name="release_date" required>
    </div>
    <div class="form-group">
    <label for="images">Afbeelding:</label>
    <input type="file" id="images" name="images" accept="image/*" required>
    </div>
    <button type="submit">Voeg Album Toe</button>
</form>
