<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div class="bg-[#4b9cd3;] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold">
        <h4><i class="fa-solid fa-calendar-days"></i> Calendar</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center my-5 p-2.5">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-7 gap-px p-2.5">
        <!-- Month name above weekdays -->
        <div class="w-full text-center my-5 flex flex-col py-3.5 px-5 text-white mb-1 shadow-md text-2xl font-semibold" style="background-color: #4b9cd3; grid-column: 1 / -1; text-align: center;">
            <h2><i class="fa-solid fa-calendar-days"></i> {{ date('F Y') }}</h2>
        </div>

        <!-- Days of the week headers starting from Saturday -->
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Saturday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Sunday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Monday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Tuesday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Wednesday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Thursday</div>
        <div class="bg-white border border-gray-300 font-bold text-center py-2.5">Friday</div>

        <!-- Generating days for the current month starting from Saturday -->
        @php
            $firstDayOfMonth = date('w', strtotime(date('Y-m-01'))); // Get the weekday index (0 = Sunday)
            $daysInMonth = date('t'); // Get the number of days in the current month
        @endphp

        @for ($i = 1; $i <= $daysInMonth + $firstDayOfMonth; $i++)
            @if ($i > $firstDayOfMonth)
                @php
                    $dayOfMonth = $i - $firstDayOfMonth;
                    $currentDayOfWeek = ($i - 1) % 7; // Calculate current day of week index
                    $hasAppointments = $calendars->filter(function ($calendar) use ($dayOfMonth) {
                        return date('j', strtotime($calendar->appointmentdate)) == $dayOfMonth;
                    })->isNotEmpty();
                @endphp

                <div class="day bg-white min-h-[100px] flex flex-col items-center justify-center p-2.5 border border-gray-300 relative cursor-pointer {{ $hasAppointments ? 'bg-blue-400' : '' }}" onclick="toggleAppointments(this)">
                    <div>{{ $dayOfMonth }}</div>
                    <div class="hourly-appointments hidden absolute top-full left-0 w-full bg-white shadow-lg z-50 p-2.5 max-h-[200px] overflow-y-auto">
                        @foreach (range(0, 23) as $hour)
                            @if (($hour >= 8 && $hour < 12) || ($hour >= 16 && $hour < 20))
                                @php
                                    $startHour = $hour;
                                    $endHour = ($hour + 1) % 24;
                                    $startPeriod = $startHour >= 12 ? 'PM' : 'AM';
                                    $endPeriod = $endHour >= 12 ? 'PM' : 'AM';

                                    // Convert 24-hour format to 12-hour format
                                    $startHour12 = $startHour % 12;
                                    $endHour12 = $endHour % 12;

                                    // Handle edge case where 12 AM or 12 PM is displayed
                                    $startHour12 = $startHour12 === 0 ? 12 : $startHour12;
                                    $endHour12 = $endHour12 === 0 ? 12 : $endHour12;
                                @endphp
                                <div class="hourly-slot mb-1 p-1 text-center border-2 border-gray-200 rounded shadow-md">
                                    <strong>{{ $startHour12 }}:00{{ $startPeriod }} - {{ $endHour12 }}:00{{ $endPeriod }}</strong>
                                    @php $hasAppointment = false; @endphp
                                    @foreach ($calendars as $calendar)
                                        @if (date('j', strtotime($calendar->appointmentdate)) == $dayOfMonth && date('G', strtotime($calendar->appointmenttime)) == $hour)
                                            <div class="appointment bg-gray-200 p-2 mt-1 rounded text-center w-full box-border">
                                                <strong>{{ $calendar->time }}</strong><br>
                                                {{ $calendar->name }}
                                                <div class="appointment-buttons mt-5 flex justify-between">
                                                    @if (!$calendar->approved)
                                                        <form method="post" action="{{ route('admin.approveCalendar', $calendar->id) }}">
                                                            @csrf
                                                            <button type="submit" class="py-1 px-2 rounded bg-green-500 text-white" title="Approve">Approve</button>
                                                        </form>
                                                    @else
                                                        <span class="text-green-500">Approved</span>
                                                    @endif
                                                    <a href="{{ route('admin.updateCalendar', $calendar->id) }}" class="py-1 px-2 rounded bg-white hover:bg-gray-300 text-gray-800" title="Update"><i class="fa-solid fa-pen"></i></a>
                                                    <a href="{{ route('admin.viewDetails', $calendar->id) }}" class="py-1 px-2 rounded bg-white hover:bg-gray-300 text-gray-800" title="View"><i class="fa-solid fa-eye"></i></a>
                                                    <form method="post" action="{{ route('admin.deleteCalendar', $calendar->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="py-1 px-2 rounded bg-white text-red-800 hover:bg-red-200" title="Delete" onclick="return confirm('Are you sure you want to delete this appointment?')"><i class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            @php $hasAppointment = true; @endphp
                                        @endif
                                    @endforeach
                                    @if (!$hasAppointment)
                                        <div>No appointment</div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="day empty bg-white border border-gray-300"></div> <!-- Empty cells before the first day of the month -->
            @endif
        @endfor
    </div>

    <script>
        function toggleAppointments(dayElement) {
            // Close all other open appointments
            document.querySelectorAll('.day.active').forEach(day => {
                if (day !== dayElement) {
                    day.classList.remove('active');
                    day.querySelector('.hourly-appointments').classList.add('hidden');
                }
            });

            // Toggle active class to show/hide hourly appointments
            dayElement.classList.toggle('active');
            const hourlyAppointments = dayElement.querySelector('.hourly-appointments');
            hourlyAppointments.classList.toggle('hidden');
        }
    </script>

</body>
</html>

@section('title')
    Calendar
@endsection

</x-app-layout>