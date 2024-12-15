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


                <!-- Terms of Agreement -->
                <div class="mt-6" x-data="{ showTerms: false }">
                    <label for="terms" class="inline-flex items-center text-sm text-gray-600">
                        <input id="terms" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="terms" required>
                        <span class="ml-2">I agree to the 
                            <a href="#" class="text-blue-600 hover:underline" @click.prevent="showTerms = true">Terms of Agreement</a>
                        </span>
                    </label>

                    <!-- Terms of Agreement Modal -->
                    <div x-show="showTerms" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full backdrop-blur-custom" style="display: none;">
                        <div class="flex justify-center items-center h-full w-full">
                            <div class="relative p-6 bg-white rounded-lg shadow-lg w-full max-w-md">
                                <div class="flex justify-between items-center border-b pb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">Terms of Agreement on Data Privacy</h3>
                                    <button @click="showTerms = false" class="text-gray-500 hover:text-gray-800">
                                        <span class="sr-only">Close</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-4 max-h-96 overflow-y-auto">
                                    <p class="text-sm text-gray-600">
                                        <strong>Introduction</strong><br>
                                        At Dela Cirna Dental Clinic, we prioritize the privacy and security of our patients' data. By using our system, you agree to the terms outlined in this Data Privacy Agreement. This document explains how your personal and medical information is collected, used, stored, and protected.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <strong>1. Data Collection</strong><br>
                                        We collect and process the following types of information:<br>
                                        - Personal Information: Name, contact number, email address, birthday, gender, and address.<br>
                                        - Medical Information: Dental history, appointments, treatment records, and related medical data.<br>
                                        - System Usage Information: Information related to the use of our online platform.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <strong>2. Purpose of Data Collection</strong><br>
                                        The data collected will only be used for:<br>
                                        - Providing dental services and managing appointments.<br>
                                        - Maintaining accurate medical records.<br>
                                        - Improving the quality of dental care and services.<br>
                                        - Complying with legal and regulatory requirements.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <strong>3. Data Storage and Security</strong><br>
                                        - All data will be securely stored in compliance with applicable laws and standards.<br>
                                        - Appropriate technical and organizational measures are in place to prevent unauthorized access, data breaches, or loss of data.<br>
                                        - Access to patient data is restricted to authorized personnel only.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <strong>4. Data Sharing</strong><br>
                                        Your information will not be shared with third parties without your explicit consent, except when required by law or when necessary to:<br>
                                        - Coordinate with laboratories or other healthcare providers for your treatment.<br>
                                        - Respond to legal requests or comply with judicial proceedings.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <strong>5. Your Rights</strong><br>
                                        As a user of our system, you have the following rights:<br>
                                        - Access: Request access to your personal data.<br>
                                        - Rectification: Request correction of inaccurate or incomplete data.<br>
                                        - Erasure: Request deletion of your data, subject to legal obligations.<br>
                                        - Objection: Object to certain types of data processing.<br>
                                        - Portability: Request a copy of your data in a commonly used format.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <strong>6. Consent</strong><br>
                                        By using our system, you consent to the collection, processing, and storage of your data as outlined in this agreement. You may withdraw your consent at any time by contacting our office, though this may impact our ability to provide certain services.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <strong>7. Amendments</strong><br>
                                        We reserve the right to amend this Data Privacy Agreement from time to time. Any changes will be communicated through our system or other appropriate channels. Continued use of our system indicates acceptance of the updated terms.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <strong>8. Contact Information</strong><br>
                                        If you have questions or concerns about this agreement or the handling of your data, please contact us at:<br>
                                        Dela Cirna Dental Clinic<br>
                                        Email: admin@bataandental.com<br>
                                        Phone: 0948-6593-662<br>
                                        Address: Old National Road, Mulawin, Orani, Bataan
                                    </p>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <button @click="showTerms = false" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .backdrop-blur-custom {
                        backdrop-filter: blur(10px);
                    }
                </style>


                <div class="mt-4 flex justify-center">
                    <x-primary-button class="w-full justify-center">
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
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('terms-modal').classList.add('hidden');
        });
    </script>

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