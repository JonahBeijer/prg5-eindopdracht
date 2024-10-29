@include('layouts.navbar')


<form id="albumForm" action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="container mt-4">
    <h2 class="text-center">Voeg een Album Toe</h2>
    <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="album_name">Album Naam:</label>
            <input type="text" id="album_name" name="album_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="artist_name">Artiest Naam:</label>
            <input type="text" id="artist_name" name="artist_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="genre_id">Genre:</label>
            <select name="genre_id" id="genre_id" class="form-control" required>
                <option value="">Selecteer een genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="release_date">Release Datum:</label>
            <input type="date" id="release_date" name="release_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="images">Afbeelding:</label>
            <input type="file" id="images" name="images" class="form-control" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="caption">Caption:</label>
            <input type="text" id="caption" name="caption" class="form-control" required>
        </div>

        <button type="submit" class="knop" onclick="disableButton(this)">Voeg Album Toe</button>
    </form>
</div>

</form>

<script>
    function disableButton(button) {
        button.disabled = true;
        button.innerText = 'Verwerken...';
        document.getElementById('albumForm').submit();
    }
</script>
</body>
</html>
