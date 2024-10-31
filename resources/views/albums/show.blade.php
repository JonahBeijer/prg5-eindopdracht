@include('layouts.navbar')

<body>
<div class="container mt-4">
    <div class="row row-cols-3 justify-content-center">
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
                    <p class="card-text"><strong>Artiest:</strong> {{ $album->artist_name }}</p>
                    <p class="card-text"><strong>Genre:</strong> {{ $album->genre ? $album->genre->name : 'Geen genre gevonden' }}</p>
                    <p class="card-text"><strong>Release Datum:</strong> {{ date('d-m-Y', strtotime($album->release_date)) }}</p>
                    <p class="card-text"><strong>Caption:</strong> {{ $album->caption }}</p>

                </div>
            </div>
        </div>
    </div>

    <!-- Comment Form -->
    <div class="comments-section">
        <!-- Comment Form -->
        @auth
            <div class="comment-form card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Laat een reactie achter:</h5>
                    <form action="{{ route('comments.store', $album->id) }}" method="POST" id="commentForm">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="knop" onclick="disableButton(this)">Plaats Reactie</button>
                    </form>

                    <!-- Weergave van foutmeldingen -->
                    @if ($errors->any())
                        <div class="alert alert-danger mt-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                    <div class="comment mb-4 border p-3" id="comment-{{ $comment->id }}">
                        <div class="d-flex align-items-start">
                            <img src="{{ $comment->user->profile_image ? asset('storage/profile_images/' . $comment->user->profile_image) : asset('storage/profile_images/default.webp') }}"
                                 alt="Profielafbeelding"
                                 class="rounded-circle me-2"
                                 style="width: 40px; height: 40px; margin-right: 5px;">
                            <div>
                                <strong>{{ $comment->user->name }}</strong> zei op {{ $comment->created_at->format('d-m-Y H:i') }}:
                                <p id="comment-content-{{ $comment->id }}">{{ $comment->content }}</p>

                                <!-- Inline bewerkformulier (standaard verborgen) -->
                                <form id="edit-form-{{ $comment->id }}" action="{{ route('comment.update', $comment->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-2">
                                        <textarea name="content" class="form-control" rows="3">{{ $comment->content }}</textarea>
                                    </div>

                                    <div class="button-group">
                                        <button type="submit" class="knop">Opslaan</button>
                                        <button type="button" class="knop" onclick="cancelEdit({{ $comment->id }})">Annuleren</button>
                                    </div>
                                </form>

                                <!-- Bewerken en Verwijderen knoppen -->
                                @if (Auth::check() && ($comment->user_id === Auth::id() || Auth::user()->status == 1))
                                    <div class="mt-2 button-group" id="action-buttons-{{ $comment->id }}">
                                        <button class="knop" onclick="editComment({{ $comment->id }})">Bewerken</button>
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="knop" onclick="return confirm('Weet je zeker dat je deze reactie wilt verwijderen?');">Verwijder</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
    </div>
</div>

<script>
    function editComment(commentId) {
        // Toon het bewerkformulier
        document.getElementById('edit-form-' + commentId).style.display = 'block';
        // Verberg de oorspronkelijke content
        document.getElementById('comment-content-' + commentId).style.display = 'none';
        // Verberg de bewerk- en verwijderknoppen
        document.getElementById('action-buttons-' + commentId).style.display = 'none';
    }

    function cancelEdit(commentId) {
        // Verberg het bewerkformulier
        document.getElementById('edit-form-' + commentId).style.display = 'none';
        // Toon de oorspronkelijke content weer
        document.getElementById('comment-content-' + commentId).style.display = 'block';
        // Toon de bewerk- en verwijderknoppen weer
        document.getElementById('action-buttons-' + commentId).style.display = 'flex';
    }


    document.getElementById('commentForm').onsubmit = function() {
        const button = document.querySelector('#commentForm .knop');
        button.disabled = true;
        button.innerText = 'Verwerken...';
    };


</script>



</body>
