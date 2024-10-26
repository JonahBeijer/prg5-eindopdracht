
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>SpinShare</title>
</head>
<nav class="navbar navbar-expand-lg navbar-light  bg-white shadow-sm">
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
<main class="py-4" id="main">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-white"><h1>Welkom bij <img src="{{ asset('storage/images/spinshare.png') }}" alt="SpinShare Logo" style="width: 150px; height: auto;"></h1> </div>

                    <div class="card-body">
                        <p>Welkom op SpinShare, dé plek om jouw favoriete muziekalbums te delen en te ontdekken! Bekijk de recent geüploade albums van onze gebruikers en laat je inspireren. Voel je vrij om albums te favorieten wanneer je maar wilt! Je kunt albums uploaden na het inloggen, en om een album te kunnen favorieten, moet je minimaal drie albums hebben geüpload.</p>
                        <p>De liefde voor muziek verbindt ons allemaal. SpinShare biedt een platform voor muziekliefhebbers om hun favoriete albums te delen en nieuwe muziek te ontdekken. Van de klassiekers tot de nieuwste hits, onze community staat klaar om jou te helpen bij het vinden van jouw volgende favoriete nummer.</p>
                        <p>Naast het delen van albums, moedigen we onze gebruikers aan om interactief te zijn door reacties en reviews achter te laten. Dit creëert een levendige en betrokken gemeenschap waar muziek de hoofdrol speelt. Of je nu een casual luisteraar bent of een doorgewinterde muziekkenner, bij SpinShare vind je altijd iets dat je aanspreekt.</p>
                        <p>In een wereld vol constante verandering en snelle trends, blijft muziek een blijvende bron van inspiratie en verbinding. Het delen van albums en het ontdekken van nieuwe geluiden kan leiden tot onvergetelijke ervaringen en nieuwe vriendschappen. Sluit je aan bij onze community en ontdek wat SpinShare voor jou kan betekenen!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

