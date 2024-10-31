@include('layouts.navbar')

<main class="py-4" id="main">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">
                        <h2>Welkom bij <img src="{{ asset('storage/images/spinshare.png') }}" alt="SpinShare Logo" style="width: 150px; height: auto;"></h2>
                    </div>
                    <div class="card-body">
                        <p>Welkom op SpinShare, dé plek waar je jouw favoriete muziekalbums kunt delen en ontdekken! Laat je inspireren door de recent geüploade albums van onze gebruikers. Zodra je bent ingelogd, kun je zelf albums uploaden, maar houd er rekening mee dat je minimaal drie albums moet hebben toegevoegd voordat je een reactie kunt delen.</p>
                        <p>De liefde voor muziek verbindt ons allemaal. SpinShare biedt een platform voor muziekliefhebbers om hun favoriete albums te delen en nieuwe muziek te verkennen. Of je nu op zoek bent naar tijdloze klassiekers of de nieuwste hits, onze community staat klaar om jou te helpen bij het vinden van jouw volgende favoriete album, terwijl je tegelijkertijd de muzieksmaak van je vrienden ontdekt.</p>
                        <p>We moedigen onze gebruikers aan om interactief te zijn door reacties achter te laten op de gedeelde albums. Dit creëert een levendige en betrokken gemeenschap waarin muziek de hoofdrol speelt. Of je nu een casual luisteraar bent of een doorgewinterde muziekkenner, bij SpinShare vind je altijd iets dat je aanspreekt.</p>
                        <p>In een wereld vol constante verandering en snelle trends blijft muziek een blijvende bron van inspiratie en verbinding. Door albums te delen en nieuwe geluiden te ontdekken, kun je onvergetelijke ervaringen opdoen en nieuwe vriendschappen sluiten. Sluit je aan bij onze community en ontdek wat SpinShare voor jou kan betekenen!</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex justify-content-center align-items-start">
                <div class="card" style="width: 90%; height: auto; min-height: 300px;"> <!-- Hier stel je de hoogte van de kaart in -->
                    @if ($album)
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
                        </div>
                    @else
                        <p>Geen recente albums gevonden.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
