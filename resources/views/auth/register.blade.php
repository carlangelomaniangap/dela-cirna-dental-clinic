<x-guest-layout>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <input id="name" type="text" name="name" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('name', session('google_user.name')) }}" required readonly>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <input id="email" type="email" name="email" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('email', session('google_user.email')) }}" required readonly>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="" disabled selected>Select your Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="birthday" :value="__('Birthday')" />
                    <input type="date" id="birthday" name="birthday" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('birthday') }}" required>
                    <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="age" :value="__('Age')" />
                    <input type="number" id="age" name="age" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('age') }}" required>
                    <x-input-error :messages="$errors->get('age')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="address" :value="__('Address')" />
                    <input type="text" id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('address') }}" required>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <div  class="mt-4">
                    <x-input-label for="phone" :value="__('Phone No.')" />
                    <input type="tel" id="phone" name="phone" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('phone') }}" required>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-primary-button class="ms-4 w-full justify-center">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
                
                <div class="text-center mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already have an account? Log In') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const birthdayInput = document.getElementById('birthday');
            const ageInput = document.getElementById('age');

            // Calculate age based on birthday
            function calculateAge(birthDate) {
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                return age;
            }

            birthdayInput.addEventListener('change', function() {
                const birthDate = new Date(this.value);
                ageInput.value = calculateAge(birthDate);
            });

            // Trigger age calculation on page load if birthday is already set
            if (birthdayInput.value) {
                birthdayInput.dispatchEvent(new Event('change'));
            }
        });
    </script>
    
    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

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
    Register
@endsection

</x-guest-layout>