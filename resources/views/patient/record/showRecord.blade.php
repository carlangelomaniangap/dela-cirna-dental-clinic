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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-users"></i> Patient List / {{ $patientlist->name }}</h4>
    </div> -->
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6 min-h-screen">
        
        <!-- Patient details -->
        <div class="bg-white shadow-md p-6 rounded-xl">
            <h1 class="text-lg lg:text-xl font-bold">Patient Details</h1>
            <div class="mt-5">
                <ul class="text-sm sm:text-base text-gray-700 list-disc pl-5">
                    <li>
                        <span class="font-semibold">Name:</span> <span>{{ $patientlist->name }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Gender:</span> <span>{{ $patientlist->gender }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Birthday:</span> <span>{{ date('F j, Y', strtotime($patientlist->birthday)) }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Age:</span> <span>{{ $patientlist->age }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Address:</span> <span>{{ $patientlist->address }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Phone:</span> <span>{{ $patientlist->phone }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Email:</span> <span>{{ $patientlist->email }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Patient notes -->
        <div class="bg-white shadow-md p-6 rounded-xl">
            
            <div class="flex justify-between">
                <h1 class="text-lg lg:text-xl font-bold">Notes</h1>
            </div>

            <!-- Display Notes -->
            <div class="flex flex-col space-y-2 max-h-48 overflow-y-auto mt-5 p-2 border border-gray-300 rounded-lg">
                @if($notes->isEmpty())
                    <p class="text-gray-800">No notes found.</p>
                @else    
                    @foreach ($notes as $note)
                        <div class="note-item p-4 bg-gray-50 rounded-md border border-gray-200">
                            <p class="justify text-gray-800 cursor-pointer">{{ $note->note }}</p>
                            <p class="hidden full-text text-gray-800 cursor-pointer">{{ $note->note }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        
        <!-- Patient records -->
        <div class="col-span-1 lg:col-start-3 lg:row-span-2 bg-white shadow-md p-6 rounded-xl">
            
            <div class="flex justify-between mb-4">
                <h1 class="text-lg lg:text-xl font-bold"><i class="fa-regular fa-folder-open"></i> List of Records</h1>
            </div>

            <div class="flex justify-between">
                <h1 class="text-lg lg:text-xl font-bold">Files</h1>
                <h1>Total Files: {{ $count }}</h1>
            </div>
            
            <div class="max-h-96 overflow-y-auto overflow-x-auto p-2 border border-gray-300 rounded-lg">
                
                <table class="min-w-full">
                    <tbody>
                        @if($records->isEmpty())
                            <tr>
                                <td class="py-4 text-gray-800">No records found.</td>
                            </tr>
                        @else
                            @foreach ($records as $record)
                                <tr class="relative group bg-white hover:bg-gray-100">
                                    <td class="py-4 px-4 max-w-20">
                                        <p class="truncate overflow-hidden overflow-ellipsis whitespace-nowrap text-gray-800 cursor-pointer">{{ $record->file }}</p>
                                        <p class="hidden full-text text-gray-800 cursor-pointer">{{ $record->file }}</p>
                                    </td>
                                    <td class="py-4">
                                        <div class="relative inline-block text-left">
                                            <!-- Hide in small screen size -->
                                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none dropdown-button opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:flex" aria-haspopup="true" aria-expanded="false" data-dropdown-id="dropdown-{{ $record->id }}">
                                                <span class="text-gray-600"><i class="fa-solid fa-ellipsis"></i></span>
                                            </button>
                                            <!-- Hide in large screen size -->
                                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none dropdown-button md:hidden" aria-haspopup="true" aria-expanded="false" data-dropdown-id="dropdown-{{ $record->id }}">
                                                <span class="text-gray-600"><i class="fa-solid fa-ellipsis"></i></span>
                                            </button>

                                            <div class="absolute right-0 z-10 mt-2 w-36 lg:w-48 px-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden dropdown-menu" id="dropdown-{{ $record->id }}" role="menu" aria-orientation="vertical">
                                                <div class="py-1" role="none">
                                                    <a href="{{ route('patient.downloadRecord', [$patientlist->id, $record->id]) }}" class="block px-4 py-2 text-sm sm:text-base text-gray-700 hover:bg-gray-100 hover:rounded-lg"><i class="fa-solid fa-download"></i> Download</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Patient upcoming and past appointment -->
        <div class="row-start-2 col-span-1 md:col-span-2 bg-white shadow-md p-6 rounded-xl">
            <!-- Form to toggle between upcoming and past appointments -->
            <form method="GET" action="{{ route('admin.showRecord', $patientlist->id) }}">
                @csrf
                <div class="flex mb-2 bg-gray-200 p-2 rounded-lg">
                    <button type="submit" name="filter" value="upcoming" class="text-sm sm:text-base px-2 lg:px-4 py-2 bg-white shadow-md text-gray-400 rounded-lg mr-2 focus:outline-none {{ $filter == 'upcoming' ? 'text-gray-800' : '' }}">
                        <strong>Upcoming Appointments</strong>
                    </button>
                    <button type="submit" name="filter" value="past" class="text-sm sm:text-base px-2 lg:px-4 py-2 bg-white shadow-md text-gray-400 rounded-lg focus:outline-none {{ $filter == 'past' ? 'text-gray-800' : '' }}">
                        <strong>Past Appointments</strong>
                    </button>
                </div>
            </form>

            <div class="space-y-2 max-h-32 overflow-y-auto p-2 bg-gray-200 rounded-lg">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButtons = document.querySelectorAll('.dropdown-button');
            const dropdownHeight = 115; // Set your fixed dropdown height here

            dropdownButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.stopPropagation(); // Prevents event from bubbling up to the window

                    const dropdownId = this.getAttribute('data-dropdown-id');
                    const dropdownMenu = document.getElementById(dropdownId);
                    const rect = this.getBoundingClientRect(); // Get button position
                    const spaceBelow = window.innerHeight - rect.bottom; // Space below button
                    const spaceAbove = rect.top; // Space above button

                    // Close all other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (menu !== dropdownMenu) {
                            menu.classList.add('hidden');
                        }
                    });

                    // Move the dropdown outside of the scrollable container (to the body)
                    const dropdownContainer = document.getElementById('dropdowns-container') || document.body;
                    dropdownContainer.appendChild(dropdownMenu);

                    // Toggle the clicked dropdown
                    const isHidden = dropdownMenu.classList.contains('hidden');
                    dropdownMenu.classList.toggle('hidden', !isHidden);

                    // Set the dropdown to be positioned absolutely
                    dropdownMenu.style.position = 'absolute';
                    dropdownMenu.style.zIndex = '50'; // Ensure it appears above other content

                    // Adjust the 'right' position to align with the left side of the button
                    const offset = 30;  // Adjust this to add a margin (e.g., 10px from the button's left)
                    dropdownMenu.style.right = `${window.innerWidth - rect.left - offset + window.scrollX}px`;

                    // Position the dropdown
                    if (isHidden) {
                        if (spaceBelow >= dropdownHeight) {
                            // Show below if there's enough space
                            dropdownMenu.style.top = `${rect.bottom + window.scrollY}px`; // Default position
                        } else if (spaceAbove >= dropdownHeight) {
                            // Show above if there's not enough space below
                            dropdownMenu.style.top = `${rect.top - dropdownHeight + window.scrollY}px`; // Adjust for spacing
                        } else {
                            // If there's not enough space above or below, keep it hidden or handle accordingly
                            dropdownMenu.classList.add('hidden'); // Or keep it open
                        }
                    }
                });
            });

            // Close dropdowns if clicked outside
            window.addEventListener('click', function () {
                document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            });
        });
    </script>
    
</body>
</html>

@section('title')
    Record
@endsection

</x-app-layout>