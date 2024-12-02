<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="mt-4 flex items-center justify-between">
            <label for="remember_me" class="items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="font-bold text-sm text-gray-600 hover:text-gray-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            
        </div>

        <div class="mt-4">
            <x-primary-button class="ms-3 w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('auth.google.redirect') }}" class="btn btn-primary">
                <i class="fa-brands fa-google"></i> Continue with Google
            </a>
        </div>
    </form>
    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    </script>

    <script>
        document.addEventListener('keydown', function (e) {
            // Disable F12 (DevTools)
            if (e.key === 'F12') {
                e.preventDefault();
            }
            // Disable Ctrl+Shift+I or Ctrl+Shift+C
            if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'C')) {
                e.preventDefault();
            }
            // Disable Ctrl+U (View source)
            if (e.ctrlKey && e.key === 'u') {
                e.preventDefault(); // Disable Ctrl+U
            }
        });
    </script>



@section('title')
    Log In
@endsection

</x-guest-layout>
