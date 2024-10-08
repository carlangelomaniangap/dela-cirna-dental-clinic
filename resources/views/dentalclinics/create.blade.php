<x-guest-layout>

    @if ($errors->any())
        <div class="mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dentalclinics.store') }}" method="POST">
        @csrf
        <h2 class="text-2xl font-semibold mb-6 text-center">Create Dental Clinic</h2>

        <div class="mb-4">
            <label for="dentalclinicname" class="block text-sm font-medium text-gray-700">Clinic Name:</label>
            <input type="text" id="dentalclinicname" name="dentalclinicname" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2">
        </div>

        <div class="mb-4">
            <label for="admin_name" class="block text-sm font-medium text-gray-700">Admin Name:</label>
            <input type="text" id="admin_name" name="admin_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Admin Email:</label>
            <input type="email" id="email" name="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2">
        </div>

        <div class="mb-4">
            <label for="admin_password" class="block text-sm font-medium text-gray-700">Admin Password:</label>
            <input type="password" id="admin_password" name="admin_password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-200">Create Clinic</button>
    </form>

@section('title')
    Create Clinic
@endsection

</x-guest-layout>