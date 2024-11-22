<x-guest-layout>

    <div class="max-w-2xl mx-auto px-4 py-8 text-justify">
        @if (session('status') === 'clinic_pending')
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg mb-6">
                <h2 class="text-lg lg:text-xl font-semibold">Your Dental Clinic and Account are Processing for Approval</h2>
                <p class="mt-2 text-sm lg:text-lg">Thank you for submitting your dental clinic details and account information. Both are currently being reviewed by the Superadmin. You will not be able to access the system until both your dental clinic and account are approved.</p>
                <p class="mt-2 text-sm lg:text-lg">Please wait for the approval process to complete. Once approved, you will have access to the full system functionalities.</p>
            </div>
        @elseif (session('status') === 'account_pending')
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg mb-6">
                <h2 class="text-lg lg:text-xl font-semibold">Your Dental Clinic and Account are Still Processing for Approval</h2>
                <p class="mt-2 text-sm lg:text-lg">Your dental clinic and account are both still under review by the Superadmin. You cannot log in or access your dental clinic management until both are approved.</p>
                <p class="mt-2 text-sm lg:text-lg">We are reviewing your application. Please be patient, and once everything is approved, you will have full access to the system.</p>
            </div>
        @endif

        <a href="{{ route('welcome') }}" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Return</a>
    </div>

@section('title')
    Pending
@endsection

</x-guest-layout>