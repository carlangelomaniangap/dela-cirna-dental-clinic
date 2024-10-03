<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dela Cirna Dental Clinic: Record Management System with Community Forum</title>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen">
    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900">
        <img class="absolute inset-0 object-cover w-full h-full z-0" src="{{ asset('images/background.png') }}" alt="Background image">
        <div class="pt-5">
            <div class="p-6 text-right z-10">
                @if (Auth::check())
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @if(Auth::user()->usertype == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Admin Dashboard</a>
                        @elseif(Auth::user()->usertype == 'patient')
                            <a href="{{ route('patient.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Patient Dashboard</a>
                        @elseif(Auth::user()->usertype == 'dentistrystudent')
                            <a href="{{ route('dentistrystudent.communityforum') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dentistry Student Dashboard</a>
                        @endif
                    </div>
                @else
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6 p-5">

                <div class="bg-white rounded-lg p-5 shadow-lg flex justify-center z-10">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>

                <div class="bg-white rounded-lg p-5 shadow-lg z-10">
                    <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold rounded-lg mb-5">
                        <h4><i class="fa-regular fa-comments"></i> Community Forum</h4>
                    </div>
                    @foreach ($communityforums as $communityforum)
                        <div class="bg-white rounded-lg p-4 mb-5 shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-center justify-between mb-2.5">
                                <div>
                                    <span class="text-blue-800 font-bold">{{ $communityforum->user->name }}</span>
                                    <span class="text-gray-500">{{ $communityforum->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
                                </div>
                            </div>
                            <div class="mt-2 text-sm leading-relaxed">
                                <p>{{ $communityforum->topic }}</p>
                            </div>
                        </div>
                    @endforeach
                    {{ $communityforums->links() }}
                </div>

            </div>
        </div>
    </div>
    
    
</body>
</html>