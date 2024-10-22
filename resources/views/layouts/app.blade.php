{{-- resources/views/layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<x-navigation />

<div class="container">
    @auth
        <button class="btn btn-primary">Exclusieve Inhoud</button>
    @endauth

    @yield('content')
</div>

<!-- In de navigatiebalk of menu -->
<li>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
</li>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

</body>
</html>
