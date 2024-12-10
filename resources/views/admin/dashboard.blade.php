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

    <div class="p-6 pb-0">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Total Patients in your Clinic</h2>
                
                <div class="bg-blue-200 p-4 rounded-lg shadow flex items-center">
                    <i class="fas fa-user-friends fa-2x text-blue-600 mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-600">Patients</h3>
                        <p class="text-3xl font-bold text-blue-700">{{ $patientCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Today's Registered Patient</h2>
                
                <div class="bg-green-200 p-4 rounded-lg shadow flex items-center">
                    <i class="fas fa-user-friends fa-2x text-green-600 mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-green-600">{{ \Carbon\Carbon::now()->format('M d, Y') }}</h3>
                        <p class="text-3xl font-bold text-green-700">{{ $recentPatientCount }}</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1">
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6 h-46">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Today's Appointments</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Total Appointments Card -->
                    <div class="bg-blue-200 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-blue-500 text-white rounded-full p-3 mr-3">
                                <i class="fas fa-calendar-check fa-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-blue-700">Total Appointments</h3>
                                <p class="text-3xl font-bold text-blue-800">{{ $todayAppointments->count() }}</p>
                            </div>
                        </div>
                    </div>
    
                    <!-- Approved Appointments Card -->
                    <div class="bg-green-200 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-green-500 text-white rounded-full p-3 mr-3">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-green-700">Approved</h3>
                                <p class="text-3xl font-bold text-green-800">{{ $approvedAppointments }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pending Appointments Card -->
                    <div class="bg-yellow-200 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 text-white rounded-full p-3 mr-3">
                                <i class="fas fa-hourglass-half fa-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-yellow-700">Pending</h3>
                                <p class="text-3xl font-bold text-yellow-800">{{ $pendingAppointments }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($todayAppointments->count() > 0)
                    <div class="mt-4 space-y-4 overflow-y-auto max-h-64">
                        @foreach($todayAppointments as $calendar)
                            <div class="border border-gray-200 rounded-lg p-4 flex flex-col sm:flex-row justify-between items-start bg-gray-50 hover:bg-gray-100 transition duration-200">
                                <div class="flex-grow mb-2 sm:mb-0">
                                    <p class="text-base lg:text-lg font-semibold text-gray-800">
                                        <strong>{{($calendar->appointmenttime)}}</strong> - 
                                        <span class="text-gray-600">{{ $calendar->user->name }}</span>
                                    </p>
                                    <p class="text-sm sm:text-base lg:text-lg text-gray-500">
                                        Reason for visit: <em>{{ $calendar->concern }}</em>
                                    </p>
                                </div>
                                <div class="text-sm sm:text-base lg:text-lg text-right">
                                    <span class="text-gray-500 font-medium">Status:</span>
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
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-4 text-sm text-gray-500 text-center">There are no appointments scheduled for today.</p>
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