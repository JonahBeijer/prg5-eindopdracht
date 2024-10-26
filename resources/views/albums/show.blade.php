<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>SpinShare</title>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <img src="{{ asset('storage/images/logo spinshare.png') }}" alt="SpinShare Logo" style="width: 150px; height: auto;">
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
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="display:inline; cursor: pointer;">Uitloggen</button>
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
<body>
<div class="container mt-4">
    <div class="row row-cols-3 justify-content-center">
        <div class="col mb-3">
            <div class="card h-100">
                <p class="card-text">
                    <small class="proffoto d-flex align-items-center" style="margin-bottom: -10px;"> <!-- Negatieve marge naar beneden -->
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
                    <p class="card-text"><strong>Artiest:</strong> {{ $album->artist_name }}</p>
                    <p class="card-text"><strong>Genre:</strong> {{ $album->genre ? $album->genre->name : 'Geen genre gevonden' }}</p>
                    <p class="card-text"><strong>Release Datum:</strong> {{ date('d-m-Y', strtotime($album->release_date)) }}</p>
                    @if (Auth::check() && ($album->users_id === Auth::id() || Auth::user()->status == 1))
                        <a href="{{ route('albums.edit', $album->id) }}" class="knop">Bewerken</a>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Comment Form -->
    <div class="comments-section">
        @auth
            <div class="comment-form card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Laat een reactie achter:</h5>
                    <form action="{{ route('comments.store', $album->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="knop">Plaats Reactie</button>
                    </form>
                </div>
            </div>
        @else
            <p><a href="{{ route('login') }}">Log in</a> om een reactie achter te laten.</p>
        @endauth

            <!-- Weergave van reacties -->
            <h3>Reacties:</h3>
            @if($album->comments->isEmpty())
                <p>Geen reacties nog.</p>
            @else
                @foreach($album->comments->sortByDesc('created_at') as $comment)
                    <div class="comment mb-3 border p-3">
                        <strong>{{ $comment->user->name }}</strong> zei op {{ $comment->created_at->format('d-m-Y H:i') }}:
                        <p id="comment-content-{{ $comment->id }}">{{ $comment->content }}</p>

                        <!-- Inline bewerkformulier (standaard verborgen) -->
                        <form id="edit-form-{{ $comment->id }}" action="{{ route('comment.update', $comment->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="3">{{ $comment->content }}</textarea>
                            </div>
                            <button type="submit" class="knop">Opslaan</button>
                            <button type="button" class="knop" onclick="cancelEdit({{ $comment->id }})">Annuleren</button>
                        </form>

                        <!-- Bewerken knop -->
                        @if (Auth::check() && ($comment->user_id === Auth::id() || Auth::user()->status == 1))
                            <button class="knop" onclick="editComment({{ $comment->id }})">Bewerken</button>

                            <!-- Verwijder knop -->
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="knop" onclick="return confirm('Weet je zeker dat je deze reactie wilt verwijderen?');">Verwijder</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            @endif

    </div>
</div>

<script>
    function editComment(commentId) {
        // Toon het bewerkformulier
        document.getElementById('edit-form-' + commentId).style.display = 'block';
    }

    function cancelEdit(commentId) {
        // Verberg het bewerkformulier
        document.getElementById('edit-form-' + commentId).style.display = 'none';
    }

    function deleteComment(commentId) {
        // Bevestiging voordat de reactie wordt verwijderd
        const confirmation = confirm('Weet je zeker dat je deze reactie wilt verwijderen?');
        if (confirmation) {
            // AJAX-aanroep om de reactie te verwijderen
            $.ajax({
                url: '/comments/' + commentId, // De URL naar de comment destroy route
                type: 'DELETE', // Type verzoek
                data: {
                    _token: '{{ csrf_token() }}' // Voeg CSRF-token toe
                },
                success: function(response) {
                    // Als de verwijdering succesvol is, verwijder de comment uit de DOM
                    $('#comment-' + commentId).remove();
                    alert('Reactie succesvol verwijderd!');
                },
                error: function(xhr) {
                    // Als er een fout optreedt
                    alert('Er is een fout opgetreden. Probeer het opnieuw.');
                }
            });
        }
    }
</script>



</body>
</html>
