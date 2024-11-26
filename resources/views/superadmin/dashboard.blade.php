<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white">
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold">{{ __('Dashboard') }}</h4>
    </div>

    <div class="p-6 pb-0">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">

            <!-- total users -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Total Users</h2>
                <div class="flex items-center justify-center mb-4 p-4 bg-blue-200 rounded-lg">
                    <i class="fas fa-users fa-3x text-blue-600 mr-4"></i>
                    <p class="text-3xl font-bold text-blue-600">{{ $usersCount }}</p>
                </div>
                <p class="text-gray-500">Keep track of registered users in <strong>Bataan Dental</strong>.</p>
            </div>

            <!-- total dentistry student -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Total Dentistry Students</h2>
                <div class="flex items-center justify-center mb-4 p-4 bg-indigo-200 rounded-lg">
                    <i class="fa-solid fa-graduation-cap fa-3x text-indigo-600 mr-4"></i>
                    <p class="text-3xl font-bold text-indigo-600">{{ $dentistrystudentCount }}</p>
                </div>
                <p class="text-gray-500">Keep track of registered users in <strong>Dentistry Students</strong>.</p>
            </div>
        </div>

        <!-- total dental clinic and admin -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Total Dental Clinic and Admin</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-200 p-4 rounded-lg shadow flex items-center">
                    <i class="fas fa-building fa-2x text-green-600 mr-4"></i>
                    <div>
                       <h3 class="text-lg font-semibold text-green-600">Dental Clinic</h3>
                        <p class="text-3xl font-bold text-green-700">{{ $dentalclinicsCount }}</p>
                    </div>
                </div>
                <div class="bg-indigo-200 p-4 rounded-lg shadow flex items-center">
                    <i class="fas fa-user-md fa-2x text-indigo-600 mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-600">Admin</h3>
                        <p class="text-3xl font-bold text-indigo-700">{{ $adminCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

@section('title')
    Dashboard
@endsection

</x-app-layout>