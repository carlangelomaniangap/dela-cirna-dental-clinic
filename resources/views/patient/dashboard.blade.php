<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <!-- <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white">
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold">{{ __('Dashboard') }}</h4>
    </div> -->

    <div class="p-6">
        <!-- Upcoming and past appointments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold pb-2 text-center">Appointments</h1>
            
            <!-- Form to toggle between upcoming and past appointments -->
            <form method="GET" action="{{ route('patient.dashboard') }}">
                @csrf
                <div class="flex space-x-4 mb-4 bg-gray-200 p-3 rounded-lg">
                    <button type="submit" name="filter" value="upcoming" class="text-sm lg:text-base px-2 lg:px-4 px-1 lg:py-2 bg-white shadow-md text-gray-400 rounded-lg mr-2 focus:outline-none {{ $filter == 'upcoming' ? 'text-gray-800' : '' }}">
                        <strong>Upcoming Appointments</strong>
                    </button>
                    <button type="submit" name="filter" value="past" class="text-sm lg:text-base px-4 py-2 bg-white shadow-md text-gray-400 rounded-lg focus:outline-none {{ $filter == 'past' ? 'text-gray-800' : '' }}">
                        <strong>Past Appointments</strong>
                    </button>
                </div>
            </form>

            <div class="space-y-2 mt-2 max-h-46 overflow-y-auto p-2 bg-gray-200 rounded-lg">
                @if($calendars->isEmpty())
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <p class="text-gray-800">No appointments found.</p>
                    </div>
                @else
                    <!-- Appointments Display -->
                    @foreach ($calendars as $calendar)
                    <a href="{{ route('patient.viewDetails', $calendar->id) }}" class="block rounded-lg p-4 bg-white hover:bg-gray-100 transition duration-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start">
                            <div class="flex-grow mb-4 sm:mb-0">
                                <p class="text-base lg:text-lg text-gray-800">
                                    <strong>{{ \Carbon\Carbon::parse($calendar->appointmentdate)->format('F j, Y') }}</strong> at <strong>{{($calendar->appointmenttime)}}</strong>
                                </p>
                                <p class="text-sm lg:text-base text-gray-600">
                                    <span>{{ $calendar->name }}</span>
                                </p>
                            </div>
                            <div class="text-sm lg:text-base text-right">
                                <p class="text-sm lg:text-base text-gray-500">
                                    Concern: <span>{{ $calendar->concern }}</span>
                                </p>
                                <span class="text-gray-500">Status:</span>
                                <span class="font-semibold 
                                    {{ 
                                        $calendar->status == 'Approved' || $calendar->status == 'ApprovedCompleted' ? 'text-green-600' : 
                                        ($calendar->status == 'Pending' ? 'text-yellow-600' : 
                                        ($calendar->status == 'Completed' ? 'text-blue-700' : 
                                        ($calendar->status == 'Cancelled' || $calendar->status == 'PendingCancelled' || $calendar->status == 'ApprovedCancelled' ? 'text-red-600' : 'text-gray-600')
                                        )
                                    )}}">
                                    {{ 
                                        $calendar->status == 'PendingCancelled' || $calendar->status == 'ApprovedCancelled' ? 'Cancelled' : $calendar->status 
                                    }}
                                </span>
                                @if ($calendar->status == 'Completed')
                                    <p class="text-sm lg:text-base text-gray-500 mt-2">
                                        <strong>Procedure:</strong> {{ $calendar->completion_reason ?? 'No reason provided' }}
                                    </p>
                                @else
                                    <p class="text-sm lg:text-base text-red-600 mt-2">
                                        This appointment is not complete yet.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

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