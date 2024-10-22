{{-- resources/views/components/navigation.blade.php --}}
<nav>
    <ul>

        @auth
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('logout') }}">Uitloggen</a></li>
        @endauth

        @guest
            <li><a href="{{ route('login') }}">Inloggen</a></li>
            <li><a href="{{ route('register') }}">Registreren</a></li>
        @endguest
    </ul>
</nav>
