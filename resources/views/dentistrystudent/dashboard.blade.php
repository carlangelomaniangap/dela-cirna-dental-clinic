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

    <div class="relative p-6">
        <img class="absolute top-0 left-0 w-full h-full object-cover z-0" src="{{ asset('images/background.png') }}" alt="Background image">
        
        <div class="relative z-10 text-center">
            <h1 class="text-3xl font-bold mb-4">TREATMENTS</h1>
            <p class="mb-6">We use only the best quality materials on the market in order to provide the best products to our patients.</p>
        </div>
        
        <div class="relative flex justify-center items-center">
            <!-- Wrapper for Treatment Cards and Add Button -->
            <div id="slider" class="flex overflow-x-auto gap-4 py-4">
                <!-- Check if there are no treatments -->
                @if($treatments->isEmpty())
                    <div class="flex-shrink-0 w-64 p-4 bg-white rounded-lg shadow-md text-center">
                        <i class="fas fa-camera text-4xl mb-4"></i>
                        <p>No treatments available. Add a new treatment.</p>
                    </div>
                @else
                    <!-- Loop through treatments and display them -->
                    @foreach($treatments as $treatment)
                        <div class="flex-shrink-0 w-64 h-80 p-4 bg-white rounded-lg shadow-md relative">
                            <!-- Treatment Info (Image, Name, Description) -->
                            <img src="{{ $treatment->image }}" alt="Treatment Image" class="w-full h-36 object-cover rounded-md mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $treatment->treatment }}</h2>
                            <p class="text-gray-600 text-sm">{{ $treatment->description }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <!-- Left Swipe Button -->
            <div class="absolute top-1/2 left-0 transform -translate-y-1/2">
                <button class="bg-gray-900 text-white rounded-full p-2 px-4 shadow-md hover:bg-gray-700 opacity-50 hover:opacity-70" id="prev-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>

            <!-- Right Swipe Button -->
            <div class="absolute top-1/2 right-0 transform -translate-y-1/2">
                <button class="bg-gray-900 text-white rounded-full p-2 px-4 shadow-md hover:bg-gray-700 opacity-50 hover:opacity-70" id="next-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <footer class="relative bg-gray-800 text-white px-4 sm:px-10 lg:px-16 xl:px-20 2xl:px-40 py-12 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="block mx-auto">
                <h3 class="font-bold text-2xl text-center">{{ $dentalclinic->dentalclinicname }}</h3>
                @if($dentalclinic->logo)
                    <div class="pt-4">
                        <img src="{{ asset('logos/' . $dentalclinic->logo) }}" alt="Logo" class="bg-white w-16 h-16 rounded-lg block mx-auto">
                    </div>
                @endif
            </div>

            <div class="block mx-auto">
                <h5 class="uppercase tracking-wider font-semibold text-2xl text-center">Contact Details</h5>
                <ul class="mt-4">
                    <li class="flex items-center opacity-75 hover:opacity-100">
                        <span>
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <span class="ml-3">
                            @foreach($users as $user)
                                {{ $user->address }}
                            @endforeach
                        </span>
                        </a>
                    </li>

                    <li class="mt-4 flex items-center opacity-75 hover:opacity-100 divider">
                        <span>
                            <i class="fa-solid fa-phone"></i>
                        </span>
                        <span class="ml-3">
                            @foreach($users as $user)
                                {{ $user->phone }}
                            @endforeach
                        </span>
                        </a>
                    </li>

                    <li class="mt-4 flex items-center opacity-75 hover:opacity-100">
                        <span>
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <span class="ml-3">
                            @foreach($users as $user)
                                {{ $user->email }}
                            @endforeach
                        </span>
                    </li>
                </ul>
            </div>

            <div class="block mx-auto">
                <div class="flex justify-start">
                    <h5 class="uppercase tracking-wider font-semibold text-2xl text-center mr-4">Opening Hours</h5>
                </div>

                <div class="mt-4 flex items-center opacity-75 hover:opacity-100">
                    <!-- Icon Button to trigger modal -->
                    <span>
                        <i class="fa-regular fa-clock"></i>
                    </span>

                    <!-- Display current schedule in the second span if it exists -->
                    <span class="ml-3">
                        @if($schedule)
                            <div>Open on: <strong>{{ $schedule->startweek }} - {{ $schedule->endweek }}</strong></div>
                            <div>Morning: <strong>{{ date('g:i A', strtotime($schedule->startmorningtime)) }} - {{ date('g:i A', strtotime($schedule->endmorningtime)) }}</strong></div>
                            <div>Afternoon: <strong>{{ date('g:i A', strtotime($schedule->startafternoontime)) }} - {{ date('g:i A', strtotime($schedule->endafternoontime)) }}</strong></div>
                            <div>Closed on: <strong>{{ $schedule->closedday }}</strong></div>
                        @else
                            <span>No schedule set yet.</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById("prev-btn").addEventListener("click", function() {
            document.getElementById("slider").scrollBy({left: -200, behavior: 'smooth'});
        });

        document.getElementById("next-btn").addEventListener("click", function() {
            document.getElementById("slider").scrollBy({left: 200, behavior: 'smooth'});
        });
    </script>

    @if ($showUserWelcome)
        <div class="fixed inset-0 flex items-center justify-center z-50" id="customPopup" style="display: flex;">
            <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Dimmed background -->
            <div class="bg-white border border-blue-400 text-blue-700 px-8 py-6 rounded-lg shadow-xl relative z-10 max-w-md w-full">
                <h2 class="text-lg font-semibold mb-2">Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-md">You are logged in as a {{ Auth::user()->usertype }}.</p>
                <div class="mt-4 flex justify-end">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-lg" onclick="closePopup()">OK</button>
                </div>
            </div>
        </div>

        <script>
            function closePopup() {
                document.getElementById('customPopup').style.display = 'none';
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Optional: Automatically close the popup after a few seconds
                setTimeout(closePopup, 5000); // Close after 5 seconds
            });
        </script>
    @endif

</body>
</html>

@section('title')
    Dashboard
@endsection

</x-app-layout>
