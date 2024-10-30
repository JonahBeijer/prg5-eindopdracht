<section>
    <header>
        <h4 class="font-medium text-gray-900">Wachtwoord aanpassen</h4>
        <p class="text-muted mt-1">Zorg ervoor dat je een lang, willekeurig wachtwoord gebruikt om je account veilig te houden.</p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="mt-3">
        @csrf
        @method('PUT')

        <!-- Huidig Wachtwoord -->
        <div class="form-group">
            <label for="current_password">Huidig Wachtwoord:</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required autocomplete="current-password">
            @error('current_password', 'updatePassword')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Nieuw Wachtwoord -->
        <div class="form-group mt-3">
            <label for="password">Nieuw Wachtwoord:</label>
            <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
            @error('password', 'updatePassword')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Bevestig Nieuw Wachtwoord -->
        <div class="form-group mt-3">
            <label for="password_confirmation">Bevestig Nieuw Wachtwoord:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Opslaan Knop en Status Bericht -->
        <div class="mt-4">
            <button type="submit" class="knop">Wachtwoord Opslaan</button>
        </div>

        <!-- Success Bericht -->
        @if (session('status') === 'password-updated')
            <p class="text-success mt-2">Wachtwoord succesvol bijgewerkt!</p>
        @endif
    </form>
</section>
