<!DOCTYPE html>
<head>
    <title>Albums</title>
</head>
<body>
<a href="{{route('albums.index')}}"> <h1>Albums</h1>
</a>

<form method="GET" action="{{ route('albums.index') }}">
    <label for="genre">Filter op genre:</label>
    <select name="genre" id="genre">
        <option value=""> Selecteer een genre </option>
        @foreach ($genres as $genre)
            <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                {{ $genre->name }}
            </option>
        @endforeach
    </select>
    <button type="submit">Filter</button>
</form>


@foreach ($albums as $album)
    <div>
        <h2>{{ $album->album_name }}</h2>
        <img src="{{ asset('storage/' . $album->images) }}" alt="{{ $album->album_name }}" width="150">
        <p>Artist: {{ $album->artist_name }}</p>
        <p>Genre: {{ $album->genre ? $album->genre->name : 'Geen genre gevonden' }}</p> <!-- Zorg dat het genre bestaat -->
        <p>Release Date: {{ date('d-m-Y', strtotime($album->release_date)) }}</p>
        <p>Status: {{ $album->status }}</p>
        <p>User ID: {{ $album->users_id }}</p>
    </div>
@endforeach

</body>
</html>
