<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dela Cirna Dental Clinic: Record Management System with Community Forum</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen">

    <header class="bg-white border-gray-200 border-b">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
            <div class="flex ml-6 text-2xl">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-14 h-14">
                <!-- <h1 class="font-bold mr-2">BATAAN</h1><h1 class="text-blue-400 font-bold">DENTAL</h1> -->
            </div>
            <div class="p-4 flex justify-end z-10">
                @if (Auth::check())
                    <div class="z-10">
                        @if(Auth::user()->usertype == 'superadmin')
                            <a href="{{ route('superadmin.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Super Admin Dashboard</a>
                        @elseif(Auth::user()->usertype == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Admin Dashboard</a>
                        @elseif(Auth::user()->usertype == 'patient')
                            <a href="{{ route('patient.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Patient Dashboard</a>
                        @elseif(Auth::user()->usertype == 'dentistrystudent')
                            <a href="{{ route('dentistrystudent.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dentistry Student Dashboard</a>
                        @endif
                    </div>
                @else
                    <div class="z-10">
                        <a href="{{ route('login') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Register</a>

                        @endif
                    </div>
                @endif
            </div>
        </div>
    </header>

    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900 pt-6">
        <img class="absolute inset-0 object-cover w-screen h-screen z-0" src="{{ asset('images/background.png') }}" alt="Background image">
        <div class="">

            <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6 p-5">

                <div class="bg-white rounded-lg p-5 shadow-lg flex flex-col justify-center z-10">
                    <div class="flex justify-center items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-4 w-36 h-36 lg:w-64 lg:h-64">
                    </div>
                    <div class="text-center h-28 lg:h-36">
                        <a href="{{ route('dentalclinics.create') }}" class="font-bold text-xl text-white hover:text-gray-300 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 bg-blue-600 p-4 px-6 rounded-lg hover:bg-blue-700">Create Clinic</a>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-5 shadow-lg z-10">
                    <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold rounded-lg mb-5">
                        <h4><i class="fa-regular fa-comments"></i> Community Forum</h4>
                    </div>
                    <tbody>
                        @if($communityforums->isEmpty())
                            <div class="bg-white rounded-lg p-4 mb-5 shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                                <p class="text-gray-600">No topic found.</p>
                            </div>
                        @else
                            @foreach ($communityforums as $communityforum)
                                <div class="bg-white rounded-lg p-4 mb-5 shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <span class="text-blue-800 font-bold">{{ $communityforum->user->name }}</span>
                                            <!-- Show user type with icon and badge -->
                                            @if ($communityforum->user->usertype === 'admin')
                                                <span class="text-xs lg:text-sm text-gray-500">
                                                    <i class="fa-solid fa-user-doctor"></i> Admin
                                                </span>
                                            @elseif ($communityforum->user->usertype === 'patient')
                                                <span class="text-xs lg:text-sm text-gray-500">
                                                    <i class="fas fa-tooth"></i> Patient
                                                </span>
                                            @elseif ($communityforum->user->usertype === 'dentistrystudent')
                                                <span class="text-xs lg:text-sm text-gray-500">
                                                    <i class="fas fa-graduation-cap"></i> Dentistry Student
                                                </span>
                                            @endif
                                            <p class="text-sm text-gray-500">{{ $communityforum->created_at->setTimezone('Asia/Manila')->format('F j, Y') }} at {{ $communityforum->created_at->setTimezone('Asia/Manila')->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm leading-relaxed break-words">
                                        <p>{{ $communityforum->topic }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </tbody>
                    {{ $communityforums->links() }}
                </div>

            </div>
        </div>
    </div>
    
    
</body>
</html>