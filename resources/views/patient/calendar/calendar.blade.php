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
        .appointment-day {
            background-color: rgba(75, 156, 211, 0.2);
        }
        .pending-appointment {
            background-color: rgba(255, 99, 71, 0.2);
        }
        .approved-appointment {
            background-color: rgba(135, 206, 250, 0.2);
        }
        .legend {
            display: flex;
            justify-content: flex-end;
            margin: 10px 20px;
            font-size: 14px;
        }
        .legend-item {
            margin-left: 15px;
        }
        .legend-color {
            display: inline-block;
            width: 15px;
            height: 15px;
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body class="min-h-screen">
    
    <div class="bg-[#4b9cd3] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold">
        <h4><i class="fa-solid fa-calendar-days"></i> Calendar</h4>
        <div class="legend">
            <div class="legend-item">
                <div class="legend-color" style="background-color: rgba(135, 206, 250, 0.5);"></div>
                Approved
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: rgba(255, 99, 71, 0.5);"></div>
                Pending
            </div>
        </div>
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
        <div class="w-full text-center my-5 flex justify-between items-center py-3.5 px-5 text-white mb-1 shadow-md text-2xl font-semibold" style="background-color: #4b9cd3; grid-column: 1 / -1;">
            <button onclick="changeMonth('prev')" class="calendar-nav-button">&lt; Prev</button>
            <h2><i class="fa-solid fa-calendar-days"></i> {{ $currentMonth->format('F Y') }}</h2>
            <button onclick="changeMonth('next')" class="calendar-nav-button">Next &gt;</button>
        </div>

        <!-- Days of the week headers -->
        @foreach(['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $day)
            <div class="bg-white border border-gray-300 font-bold text-center py-2.5">{{ $day }}</div>
        @endforeach

        <!-- Generating days for the current month -->
        @php
            $firstDayOfMonth = (clone $currentMonth)->modify('first day of this month');
            $lastDayOfMonth = (clone $currentMonth)->modify('last day of this month');
            $startDay = (clone $firstDayOfMonth)->modify('-' . ($firstDayOfMonth->format('w') + 1) . ' days');
            $endDay = (clone $lastDayOfMonth)->modify('+' . (5 - $lastDayOfMonth->format('w')) . ' days');
        @endphp

        @for ($day = clone $startDay; $day <= $endDay; $day->modify('+1 day'))
            @php
                $isCurrentMonth = $day->format('m') == $currentMonth->format('m');
                $hasApprovedAppointment = $calendars->contains(fn($calendar) => $calendar->appointmentdate == $day->format('Y-m-d') && $calendar->approved === 'Approved');
                $hasPendingAppointment = $calendars->contains(fn($calendar) => $calendar->appointmentdate == $day->format('Y-m-d') && $calendar->approved === 'Pending Approval');
                $dayClass = '';
                if ($hasApprovedAppointment) {
                    $dayClass = 'approved-appointment';
                } elseif ($hasPendingAppointment) {
                    $dayClass = 'pending-appointment';
                }
            @endphp

            <div class="day bg-white min-h-[100px] flex flex-col items-center justify-center p-2.5 border border-gray-300 relative cursor-pointer {{ !$isCurrentMonth ? 'text-gray-400' : '' }} {{ $dayClass }}" onclick="toggleAppointments(this)">
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
                                            <span class="{{ $calendar->approved === 'Approved' ? 'text-green-500' : 'text-yellow-500' }}">
                                                {{ $calendar->approved }}
                                            </span>
                                        </div>
                                        @php $hasAppointment = true; @endphp
                                    @endif
                                @endforeach
                                @if (!$hasAppointment)
                                    <div class="text-gray-400 text-xs">No Appointments</div>
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
            document.querySelectorAll('.day.active').forEach(day => {
                if (day !== dayElement) {
                    day.classList.remove('active');
                    day.querySelector('.hourly-appointments').classList.add('hidden');
                }
            });

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
