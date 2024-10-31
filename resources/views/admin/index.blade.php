@include('layouts.navbar')

<div class="container mt-4">
    <h1>Admin - Albums Overzicht</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
        <tr style="font-size: 0.9em;">
            <th>Album</th>
            <th>Artiest</th>
            <th>Genre</th>
            <th>Releasedatum</th>
            <th>Afbeelding</th>
            <th>Gebruiker</th>
            <th>Caption</th>
            <th>Status</th>
            <th>Actie</th>
        </tr>
        </thead>
        <tbody>
        @foreach($albums as $album)
            <tr>
                <td style="font-size: 0.9em;">{{ $album->album_name }}</td>
                <td style="font-size: 0.9em;">{{ $album->artist_name }}</td>
                <td style="font-size: 0.9em;">{{ $album->genre ? $album->genre->name : 'Geen genre gevonden' }}</td>
                <td style="font-size: 0.9em;">{{ date('d-m-Y', strtotime($album->release_date)) }}</td>
                <td>
                    <img src="{{ asset('storage/' . $album->images) }}" class="card-img-top" alt="{{ $album->album_name }}" style="width: 40px; height: auto;">
                </td>
                <td style="font-size: 0.9em;">{{ $album->user->name }}</td>
                <td style="font-size: 0.9em;">{{ $album->caption }}</td>
                <td style="font-size: 0.9em;">{{ $album->is_active ? 'Actief' : 'Inactief' }}</td>
                <td>
                    <form action="{{ route('admin.albums.toggle', $album->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="knop btn-sm -{{ $album->is_active ? 'danger' : 'success' }}">
                            {{ $album->is_active ? 'Deactiveer' : 'Activeer' }}
                        </button>
                    </form>
                </td>
                @if (Auth::user()->status == 1)
                    <td class="d-flex">
                        <a href="{{ route('albums.edit', $album->id) }}" class="knop btn-sm">Bewerken</a>

                        <form action="{{ route('albums.admin.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit album wilt verwijderen?');" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="knop btn-sm">Verwijder</button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
