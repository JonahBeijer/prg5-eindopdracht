<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Naam -->
        <div class="form-group">
            <label for="name" class="font-semibold">Naam:</label>
            <input type="text" id="name" name="name" class="form-control" required autofocus autocomplete="name" value="{{ old('name', $user->name) }}">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- E-mail -->
        <div class="form-group mt-3">
            <label for="email" class="font-semibold">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" required autocomplete="email" value="{{ old('email', $user->email) }}">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


    <div class="flex items-center gap-4">
            <div class="mt-4">
                <button type="submit" class="knop">Bewerken</button>
            </div>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
