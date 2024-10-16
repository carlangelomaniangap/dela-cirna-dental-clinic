<x-guest-layout>

    <form action="{{ route('dentalclinics.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h2 class="text-2xl font-semibold text-center">Create Dental Clinic</h2>

        <h1 class="mt-6 font-semibold">Dental Clinic Details</h1>

        <div class="mt-4">
            <x-input-label for="logo" :value="__('Logo')" />
            <input type="file" name="logo" accept="image/*" class="block mt-1 w-full" required>
            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="dentalclinicname" :value="__('Name')" />
            <input type="text" id="dentalclinicname" name="dentalclinicname" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2" value="{{ old('dentalclinicname') }}" required>
            <x-input-error :messages="$errors->get('dentalclinicname')" class="mt-2" />
        </div>

        <h1 class="mt-6 font-semibold">Admin Account Details</h1>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
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
            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="" disabled selected>Select your Gender</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }} >Male</option>
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
            <input type="number" id="age" name="age" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('age') }}"  required>
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <input type="text" id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('address') }}"  required>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone No.')" />
            <input type="tel" id="phone" name="phone" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('phone') }}"  required>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-200 mt-4">Create Clinic</button>
    </form>

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

@section('title')
    Create Clinic
@endsection

</x-guest-layout>