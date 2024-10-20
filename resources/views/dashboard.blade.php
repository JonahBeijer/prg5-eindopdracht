{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welkom op de Dashboard Pagina</h1>

        @auth
            <p>Hallo, {{ Auth::user()->name }}! Je bent ingelogd.</p>
        @endauth

        @guest
            <p>Je bent niet ingelogd. <a href="{{ route('login') }}">Log in</a> of <a href="{{ route('register') }}">registreer</a> om verder te gaan.</p>
        @endguest


    </div>
@endsection





