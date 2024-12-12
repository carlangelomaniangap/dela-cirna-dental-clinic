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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-calendar-days"></i> Calendar</h4>
    </div> -->

    @if(session('success') || $errors->any())
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="relative p-4 w-full max-w-md">
                <div class="relative p-5 text-center bg-white rounded-lg shadow">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center" onclick="this.closest('.fixed').style.display='none'">
                        <i class="fa-solid fa-xmark text-lg"></i>
                        <span class="sr-only">Close modal</span>
                    </button>

                    @if(session('success'))
                        <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-check text-green-500 text-2xl"></i>
                            <span class="sr-only">Success</span>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-full bg-red-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-xmark text-red-500 text-2xl"></i>
                            <span class="sr-only">Error</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <p class="mb-4 text-lg font-semibold text-gray-900">{{ session('success') }}</p>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="mb-4 text-lg font-semibold text-red-600">{{ $error }}</p>
                        @endforeach
                    @endif

                    @if(session('success'))
                        <button type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300" onclick="this.closest('.fixed').style.display='none'">
                            Continue
                        </button>
                    @else
                        <button type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300" onclick="this.closest('.fixed').style.display='none'">
                            Continue
                        </button>
                    @endif
                    
                </div>
            </div>
        </div>
    @endif

    @php
        $currentMonth = isset($_GET['month']) ? new DateTime($_GET['month']) : new DateTime();
    @endphp

    <div class="grid grid-cols-7 p-6">

        <div class="bg-white p-3 shadow-lg mb-4 flex justify-end" style="grid-column: 1 / -1;">
            <p class="flex items-center text-xs sm:text-sm text-right">
                <strong class="text-gray-600 mr-2 text-xs sm:text-sm">Colors Indicator:</strong>
                <span class="bg-yellow-500 text-white px-2 py-1 rounded mr-2 text-xs sm:text-sm">Pending</span>
                <span class="bg-green-500 text-white px-2 py-1 rounded mr-2 text-xs sm:text-sm">Approved</span>
                <span class="bg-blue-500 text-white px-2 py-1 rounded mr-2 text-xs sm:text-sm">Completed</span>
            </p>
        </div>

        <!-- Month navigation and display -->
        <div class="w-full text-center flex justify-between items-center py-3.5 px-5 text-white shadow-md" style="background-color: #4b9cd3; grid-column: 1 / -1;">
            <button onclick="changeMonth('prev')" class="text-xs sm:text-base lg:text-xl font-semibold"><i class="fa-solid fa-backward"></i></button>
            <h2 class="text-base sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-calendar-days"></i> {{ $currentMonth->format('F Y') }}</h2>
            <button onclick="changeMonth('next')" class="text-xs sm:text-base lg:text-xl font-semibold"><i class="fa-solid fa-forward"></i></button>
        </div>

        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:flex sm:justify-center hidden">Saturday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:flex sm:justify-center hidden">Sunday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:flex sm:justify-center hidden">Monday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:flex sm:justify-center hidden">Tuesday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:flex sm:justify-center hidden">Wednesday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:flex sm:justify-center hidden">Thursday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:flex sm:justify-center hidden">Friday</div>

        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:hidden">Sa</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:hidden">Su</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:hidden">Mo</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:hidden">Tu</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:hidden">We</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:hidden">Th</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5 sm:hidden">Fr</div>

        @php
            $firstDayOfMonth = (clone $currentMonth)->modify('first day of this month');
            $lastDayOfMonth = (clone $currentMonth)->modify('last day of this month');
            $startDay = (clone $firstDayOfMonth)->modify('-' . ($firstDayOfMonth->format('w') + 1) . ' days');
            $endDay = (clone $lastDayOfMonth)->modify('+' . (5 - $lastDayOfMonth->format('w')) . ' days');
        @endphp

        @for ($day = clone $startDay; $day <= $endDay; $day->modify('+1 day'))
            @php
                $isCurrentMonth = $day->format('m') == $currentMonth->format('m');
                $hasApprovedAppointment = $calendars->contains(fn($calendar) => $calendar->appointmentdate == $day->format('Y-m-d') && $calendar->status === 'Approved');
                $hasPendingAppointment = $calendars->contains(fn($calendar) => $calendar->appointmentdate == $day->format('Y-m-d') && $calendar->status === 'Pending');
                $hasCompletedAppointment = $calendars->contains(fn($calendar) => $calendar->appointmentdate == $day->format('Y-m-d') && $calendar->status === 'Completed');
            @endphp

            <div class="day py-6 flex flex-col items-center justify-center p-2.5 border border-gray-300 relative cursor-pointer {{ $hasPendingAppointment ? 'bg-yellow-500' : ($hasApprovedAppointment ? 'bg-green-500' : ($hasCompletedAppointment ? 'bg-blue-500' : 'bg-white')) }}" onclick="toggleAppointments(this)">
                <div>{{ $day->format('j') }}</div>
                <div class="hourly-appointments hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white shadow-lg rounded-lg h-64 w-64 overflow-y-auto p-6">
                        <div class="flex flex-col">
                            <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="text-lg font-semibold text-center rounded-lg mb-4 py-2 px-2">{{ $day->format('F j, Y') }}</div>
                            @foreach (['8:00 AM - 9:00 AM', '9:00 AM - 10:00 AM', '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '3:00 PM - 4:00 PM', '4:00 PM - 5:00 PM', '5:00 PM - 6:00 PM', '6:00 PM - 7:00 PM', '7:00 PM - 8:00 PM'] as $timeSlot)
                                <div class="hourly-slot mb-1 p-1 text-center border-2 border-gray-200 rounded shadow-md">
                                    <strong>{{ $timeSlot }}</strong>
                                    @php $hasActiveAppointment = false; @endphp
                                    @foreach ($calendars as $calendar)
                                        @if ($calendar->appointmentdate == $day->format('Y-m-d') && $calendar->appointmenttime == $timeSlot && !in_array($calendar->status, ['ApprovedCancelled', 'PendingCancelled']))
                                            @if (!in_array($calendar->status, ['ApprovedCancelled', 'PendingCancelled']))
                                                <div class="appointment bg-gray-200 p-2 mt-1 rounded text-center w-full box-border">
                                                    <div>{{ $calendar->user->name }}</div>
                                                    <div class="appointment-buttons mt-2">
                                                        @if ($calendar->status === 'Pending')
                                                            <div class="flex justify-center items-center space-x-2">
                                                                <form method="post" action="{{ route('admin.approveCalendar', ['calendarId' => $calendar->id, 'status' => 'approve']) }}">
                                                                    @csrf
                                                                    <button type="submit" class="py-1 px-2 rounded bg-yellow-500 text-white text-sm">Pending</button>
                                                                </form>
                                                                <button onclick="openCancelModal({{ $calendar->id }}, 'pendingcancel')" class="py-1 px-2 rounded bg-red-500 text-white text-sm">Cancel</button>
                                                            </div>
                                                        @elseif ($calendar->status === 'Approved')
                                                            <div class="flex justify-center items-center space-x-2">
                                                                <form method="post" action="{{ route('admin.approveCalendar', ['calendarId' => $calendar->id, 'status' => 'complete']) }}">
                                                                    @csrf
                                                                    <button type="submit" class="py-1 px-2 rounded bg-blue-500 text-white text-sm">Complete</button>
                                                                </form>
                                                                <button onclick="openCancelModal({{ $calendar->id }}, 'approvecancel')" class="py-1 px-2 rounded bg-red-500 text-white text-sm">Cancel</button>
                                                            </div>
                                                        @elseif ($calendar->status === 'Completed')
                                                            <p>Status: <span class="text-blue-700 text-sm">Completed</span></p>
                                                        @endif
                                                        <a href="{{ route('admin.viewDetails', $calendar->id) }}" class="inline-flex items-center justify-center py-1 px-2 mt-2 rounded bg-gray-500 text-white text-sm hover:bg-gray-600">
                                                            <i class="fa-solid fa-eye mr-2"></i>
                                                            View Details
                                                        </a>
                                                    </div>
                                                </div>
                                                @php $hasActiveAppointment = true; @endphp
                                             @endif
                                        @endif
                                    @endforeach
                                    @if (!$hasActiveAppointment)
                                        <div class="text-gray-400 text-xs">No Appointments</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancellation Reason Modal -->
            <div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white shadow-lg rounded-lg p-6 w-96">
                    <h2 class="text-xl font-semibold mb-4">Cancel Appointment</h2>
                    <form id="cancelForm" method="post" action="">
                        @csrf
                        <div class="mb-4">
                            <label for="cancel_reason" class="block text-sm font-medium text-gray-700">Reason for Cancellation</label>
                            <textarea id="cancel_reason" name="cancel_reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeCancelModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Close</button>
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Confirm Cancellation</button>
                        </div>
                    </form>
                </div>
            </div>
        @endfor
    </div>

    <script>
        function toggleAppointments(element) {
            const appointmentsDiv = element.querySelector('.hourly-appointments');
            appointmentsDiv.classList.toggle('hidden');
        }

        function openCancelModal(calendarId, status) {
            const modal = document.getElementById('cancelModal');
            const form = document.getElementById('cancelForm');
            form.action = `{{ route('admin.approveCalendar', ['calendarId' => ':calendarId', 'status' => ':status']) }}`
                .replace(':calendarId', calendarId)
                .replace(':status', status);
            modal.classList.remove('hidden');
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
        }
    </script>

    <script>
        function toggleAppointments(dayElement) {
            // Close other open appointments
            document.querySelectorAll('.day.active').forEach(day => {
                if (day !== dayElement) {
                    day.classList.remove('active');
                    day.querySelector('.hourly-appointments').classList.add('hidden');
                }
            });

            // Toggle the current day's appointments
            dayElement.classList.toggle('active');
            const hourlyAppointments = dayElement.querySelector('.hourly-appointments');
            hourlyAppointments.classList.toggle('hidden');
        }

        function changeMonth(direction) {
            const urlParams = new URLSearchParams(window.location.search);
            let currentMonth = new Date(urlParams.get('month') || new Date());
            if (direction === 'prev') {
                currentMonth.setMonth(currentMonth.getMonth() - 1);
            } else if (direction === 'next') {
                currentMonth.setMonth(currentMonth.getMonth() + 1);
            }
            urlParams.set('month', currentMonth.toISOString().split('T')[0]);
            window.location.search = urlParams.toString();
        }
    </script>

</body>
</html>

@section('title')
    Calendar
@endsection

</x-app-layout>