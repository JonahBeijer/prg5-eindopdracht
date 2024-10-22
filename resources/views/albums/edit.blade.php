
<form action="{{ route('albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-group">
    <label for="album_name">Album Naam:</label>
    <input type="text" id="album_name" name="album_name"
           value="{{$album-> album_name}}"
           required>
    </div>
    <div class="form-group">
    <label for="artist_name">Artiest Naam:</label>
    <input type="text" id="artist_name" name="artist_name"
           value="{{$album-> artist_name}}"
           required>
    </div>
    <div class="form-group">
        <label for="genre_id">Genre:</label>
        <select name="genre_id" id="genre_id" required>
            <option value="">Selecteer een genre</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ $genre->id == $album->genre_id ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
    <label for="release_date">Release Datum:</label>
    <input type="date" id="release_date" name="release_date"
           value="{{$album-> release_date}}"
           required>
    </div>
    <div class="form-group">
        <label for="images">Afbeelding:</label>
        <input type="file" id="images" name="images" accept="image/*">

        @if($album->images)
            <div>
                <p>Huidige afbeelding:</p>
                <img src="{{ asset('storage/' . $album->images) }}" alt="{{ $album->album_name }}" width="150">
            </div>
        @endif
    </div>
    <button type="submit">Update Album</button >
    <form action="{{ route('albums.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit album wilt verwijderen?');">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Verwijder Album</button>
    </form>



</form>
