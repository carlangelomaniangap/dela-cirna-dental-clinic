<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        .calendar-nav-button {
            background-color: #4b9cd3;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .calendar-nav-button:hover {
            background-color: #3a7ca5;
        }
    </style>
</head>
<body class="min-h-screen">
    
    <div class="bg-[#4b9cd3] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold">
        <h4><i class="fa-solid fa-calendar-days"></i> Calendar</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center my-5 p-2.5">
            {{ session('success') }}
        </div>
    @endif

    @php
        $currentMonth = isset($_GET['month']) ? new DateTime($_GET['month']) : new DateTime();
    @endphp

    <div class="grid grid-cols-7 gap-px p-2.5">
        <!-- Month navigation and display -->
        <div class="w-full text-center my-5 flex justify-between items-center py-3.5 px-5 text-white mb-1 shadow-md text-2xl font-semibold" style="background-color: #4b9cd3; grid-column: 1 / -1;">
            <button onclick="changeMonth('prev')" class="calendar-nav-button">&lt; Prev</button>
            <h2><i class="fa-solid fa-calendar-days"></i> {{ $currentMonth->format('F Y') }}</h2>
            <button onclick="changeMonth('next')" class="calendar-nav-button">Next &gt;</button>
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
            $firstDayOfMonth = (clone $currentMonth)->modify('first day of this month');
            $lastDayOfMonth = (clone $currentMonth)->modify('last day of this month');
            $startDay = (clone $firstDayOfMonth)->modify('-' . ($firstDayOfMonth->format('w') + 1) . ' days');
            $endDay = (clone $lastDayOfMonth)->modify('+' . (5 - $lastDayOfMonth->format('w')) . ' days');
        @endphp

        @for ($day = clone $startDay; $day <= $endDay; $day->modify('+1 day'))
            @php
                $isCurrentMonth = $day->format('m') == $currentMonth->format('m');
                $hasAppointments = $calendars->contains('appointmentdate', $day->format('Y-m-d'));
            @endphp

            <div class="day bg-white min-h-[100px] flex flex-col items-center justify-center p-2.5 border border-gray-300 relative cursor-pointer {{ !$isCurrentMonth ? 'text-gray-400' : '' }} {{ $hasAppointments ? 'bg-blue-100' : '' }}" onclick="toggleAppointments(this)">
                <div>{{ $day->format('j') }}</div>
                <div class="hourly-appointments hidden absolute top-full left-0 w-full bg-white shadow-lg z-50 p-2.5 max-h-[200px] overflow-y-auto">
                    @foreach (range(8, 19) as $hour)
                        @if (($hour >= 8 && $hour < 12) || ($hour >= 16 && $hour < 20))
                            @php
                                $startHour = $hour;
                                $endHour = $hour + 1;
                                $startPeriod = $startHour >= 12 ? 'PM' : 'AM';
                                $endPeriod = $endHour >= 12 ? 'PM' : 'AM';
                                $startHour12 = $startHour > 12 ? $startHour - 12 : $startHour;
                                $endHour12 = $endHour > 12 ? $endHour - 12 : $endHour;
                            @endphp
                            <div class="hourly-slot mb-1 p-1 text-center border-2 border-gray-200 rounded shadow-md">
                                <strong>{{ $startHour12 }}:00{{ $startPeriod }} - {{ $endHour12 }}:00{{ $endPeriod }}</strong>
                                @php $hasAppointment = false; @endphp
                                @foreach ($calendars as $calendar)
                                    @if ($calendar->appointmentdate == $day->format('Y-m-d') && date('G', strtotime($calendar->appointmenttime)) == $hour)
                                        <div class="appointment bg-gray-200 p-2 mt-1 rounded text-center w-full box-border">
                                            <strong>{{ date('g:i A', strtotime($calendar->appointmenttime)) }}</strong><br>
                                            {{ $calendar->name }}
                                            <div class="appointment-buttons mt-2 flex justify-between">
                                                @if ($calendar->approved === 'Pending Approval')
                                                    <form method="post" action="{{ route('admin.approveCalendar', $calendar->id) }}">
                                                        @csrf
                                                        <button type="submit" class="py-1 px-2 rounded bg-green-500 text-white text-xs" title="Approve">Approve</button>
                                                    </form>
                                                @else
                                                    <span class="text-green-500 text-xs">{{ $calendar->approved }}</span>
                                                @endif
                                                <a href="{{ route('admin.viewDetails', $calendar->id) }}" class="py-1 px-2 rounded bg-white hover:bg-gray-300 text-gray-800 text-xs" title="View"><i class="fa-solid fa-eye"></i></a>
                                                <form method="post" action="{{ route('admin.deleteCalendar', $calendar->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="py-1 px-2 rounded bg-white text-red-800 hover:bg-red-200 text-xs" title="Delete" onclick="return confirm('Are you sure you want to delete this appointment?')"><i class="fa-solid fa-trash"></i></button>
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

        function changeMonth(direction) {
            const urlParams = new URLSearchParams(window.location.search);
            const currentMonth = new Date(urlParams.get('month') || new Date());
            
            if (direction === 'prev') {
                currentMonth.setMonth(currentMonth.getMonth() - 1);
            } else {
                currentMonth.setMonth(currentMonth.getMonth() + 1);
            }
            
            urlParams.set('month', currentMonth.toISOString().split('T')[0].substring(0, 7));
            window.location.search = urlParams.toString();
        }
    </script>
</body>
</html>

@section('title')
    Calendar
@endsection
</x-app-layout>