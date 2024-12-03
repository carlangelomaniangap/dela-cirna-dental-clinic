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
                        @foreach($todayAppointments as $appointment)
                            <div class="border border-gray-200 rounded-lg p-4 flex flex-col sm:flex-row justify-between items-start bg-gray-50 hover:bg-gray-100 transition duration-200">
                                <div class="flex-grow mb-2 sm:mb-0">
                                    <p class="text-base lg:text-lg font-semibold text-gray-800">
                                        <strong>{{ \Carbon\Carbon::parse($appointment->appointmenttime)->format('g:i A') }}</strong> - 
                                        <span class="text-gray-600">{{ $appointment->user->name }}</span>
                                    </p>
                                    <p class="text-sm sm:text-base lg:text-lg text-gray-500">
                                        Reason for visit: <em>{{ $appointment->concern }}</em>
                                    </p>
                                </div>
                                <div class="text-sm sm:text-base lg:text-lg text-right">
                                    <span class="text-gray-500 font-medium">Status:</span>
                                    <span class="font-semibold {{ $appointment->status == 'Approved' ? 'text-green-600' : ($appointment->status == 'Pending' ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $appointment->status }}
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

    <!--Treatments-->
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
                        <div class="bg-gray-300 p-6 rounded-md">
                            <i class="fas fa-camera text-3xl py-12"></i>
                            
                        </div>
                        <p class="py-12 mb-1 text-gray-500 text-center">No treatments.</p>
                    </div>
                @else
                    <!-- Loop through treatments and display them -->
                    @foreach($treatments as $treatment)
                        <div id="treatment-card-{{ $treatment->id }}" class="treatment-card flex-shrink-0 w-64 h-80 p-4 pt-0 bg-white rounded-lg shadow-md relative">
                            <!-- Edit and Delete buttons -->
                            <div class="flex justify-between">
                                <!-- Edit Button -->
                                <button type="button" class="edit-link text-blue-500 hover:text-blue-700" data-treatment-id="{{ $treatment->id }}">
                                    <i class="fas fa-edit"></i> <!-- Pencil icon for edit -->
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('treatments.destroy', $treatment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this treatment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i> <!-- 'X' icon for delete -->
                                    </button>
                                </form>
                            </div>

                            <!-- Treatment Info (Image, Name, Description) -->
                            <img src="{{ $treatment->image }}" alt="Treatment Image" class="w-full h-36 object-cover rounded-md mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $treatment->treatment }}</h2>
                            <p class="text-gray-600 text-sm">{{ $treatment->description }}</p>
                        </div>

                        <!-- Edit Form (Initially hidden) -->
                        <form id="edit-treatment-form-{{ $treatment->id }}" class="hidden bg-white shadow-md rounded-lg p-4 w-80 treatment-form treatment-card flex-shrink-0 w-64 h-80 relative border-2" action="{{ route('treatments.update', $treatment->id) }}" method="POST" enctype="multipart/form-data">
                            
                            @csrf

                            @method('PUT')
                            
                            <h2 class="text-xl font-bold text-center">Update</h2>

                            <!-- Image -->
                            <label for="image" class="block text-sm font-semibold text-gray-700 mt-2">Image</label>
                            <input type="file" name="image" accept="image/*" class="mt-2 block w-full text-sm text-gray-500">
                            <!-- @if($treatment->image)
                                <div class="mt-2">
                                    <img src="{{ asset($treatment->image) }}" alt="Current Treatment Image" class="w-24 h-24 rounded-lg">
                                </div>
                            @endif -->

                            <!-- Treatment Name -->
                            <label for="treatment" class="block text-sm font-semibold text-gray-700 mt-2">Treatment</label>
                            <input type="text" name="treatment" id="treatment" value="{{ old('treatment', $treatment->treatment) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>

                            <!-- Description -->
                            <label for="description" class="block text-sm font-semibold text-gray-700 mt-2">Description</label>
                            <textarea name="description" id="description" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>{{ old('description', $treatment->description) }}</textarea>

                            <div class="mt-2 flex justify-end">
                                <button type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2 mr-2">Update</button>
                                <button type="button" class="cancel-edit bg-gray-500 text-white rounded-lg px-4 py-2" data-treatment-id="{{ $treatment->id }}">Cancel</button>
                            </div>
                        </form>
                    @endforeach
                @endif

                <!-- Treatment Add Card: Initially displays a plus button to show form -->
                <div id="treatment-add-card" class="treatment-card flex-shrink-0 w-64 h-80 p-4 bg-white rounded-lg shadow-md relative">
                    <!-- Placeholder content (empty card with a plus button) -->
                    <div id="treatment-empty" class="flex flex-col justify-center items-center">
                        <!-- + Button to trigger the form -->
                        <button id="add-treatment-btn" class="opacity-50 text-gray-500 rounded-full text-5xl px-4 py-2 mt-4"><i class="fa-solid fa-plus"></i></button>
                    </div>

                    <!-- Form for Adding Treatment (Initially hidden) -->
                    <form id="treatment-form" class="hidden" action="{{ route('treatments.store') }}" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="dentalclinic_id" value="{{ Auth::user()->dentalclinic_id }}">
                    
                        @csrf
                        
                        <h2 class="text-xl font-bold text-center">Create</h2>

                        <!-- Image -->
                        <label for="image" class="block text-sm font-semibold text-gray-700 mt-2">Image</label>
                        <input type="file" name="image" accept="image/*" class="mt-2 block w-full text-sm text-gray-500">

                        <!-- Treatment -->
                        <label for="treatment" class="block text-sm font-semibold text-gray-700 mt-2">Treatment</label>
                        <input type="text" name="treatment" id="treatment" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>

                        <!-- Description -->
                        <label for="description" class="block text-sm font-semibold text-gray-700 mt-2">Description</label>
                        <textarea name="description" id="description" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required></textarea>

                        <div class="mt-1 flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2 mr-2">Save</button>
                            <button type="button" id="cancel-btn" class="bg-gray-500 text-white rounded-lg px-4 py-2">Cancel</button>
                        </div>
                    </form>
                </div>
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
            <div class="block mx-auto mb-6">
                <h3 class="font-bold text-2xl text-center">Dela Cirna Dental Clinic</h3>
                <div class="pt-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="bg-white w-16 h-16 rounded-lg block mx-auto">
                </div>
            </div>

            <div class="block mx-auto mb-6">
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

            <div class="block mx-auto mb-0 lg:mb-6">
                <div class="flex justify-start">
                    <h5 class="uppercase tracking-wider font-semibold text-2xl text-center mr-4">Opening Hours</h5>
                    <!-- Trigger Button to Open Modal -->
                    <button type="button" id="openModalButton" class="px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        {{ $schedule ? 'Edit' : 'Add' }}
                    </button>
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
                            <span class="flex justify-between">
                                <div>Closed on: <strong>{{ $schedule->closedday }}</strong></div>
                                <!-- Delete button near the "Open on" text -->
                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 text-red-600 bg-gray-100 bg-opacity-50 rounded-full hover:bg-red-600 text-xs">
                                        <i class="fa-solid fa-x"></i>
                                    </button>
                                </form>
                            </span>
                        @else
                            <span>No schedule set yet.</span>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Modal for Adding/Editing Opening Hours -->
            <div id="scheduleModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
                <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-md">
                    <h2 class="text-base sm:text-2xl font-semibold text-gray-700" id="modalTitle">
                        {{ $schedule ? 'Edit Opening Hours' : 'Add Opening Hours' }}
                    </h2>

                    <form action="{{ isset($schedule) ? route('schedules.update', $schedule->id) : route('schedules.store') }}" method="POST">
                        
                        @csrf
                        
                        @if(isset($schedule))  
                            @method('PUT') <!-- If editing, include PUT method -->
                        @endif

                        <!-- Hidden field for updating existing schedule -->
                        @if($schedule)
                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        @endif

                        <div>
                            <label for="startweek" class="mt-2 block text-xs sm:text-sm font-medium text-gray-700">Start Week</label>
                            <select id="startweek" name="startweek" class="mt-1 text-xs sm:text-sm text-gray-700 block w-full px-2 py-1 sm:px-3 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="" disabled selected>Select here</option>
                                <option value="Monday" {{ (old('startweek', $schedule->startweek ?? '') == 'Monday') ? 'selected' : '' }}>Monday</option>
                                <option value="Tuesday" {{ (old('startweek', $schedule->startweek ?? '') == 'Tuesday') ? 'selected' : '' }}>Tuesday</option>
                                <option value="Wednesday" {{ (old('startweek', $schedule->startweek ?? '') == 'Wednesday') ? 'selected' : '' }}>Wednesday</option>
                                <option value="Thursday" {{ (old('startweek', $schedule->startweek ?? '') == 'Thursday') ? 'selected' : '' }}>Thursday</option>
                                <option value="Friday" {{ (old('startweek', $schedule->startweek ?? '') == 'Friday') ? 'selected' : '' }}>Friday</option>
                                <option value="Saturday" {{ (old('startweek', $schedule->startweek ?? '') == 'Saturday') ? 'selected' : '' }}>Saturday</option>
                                <option value="Sunday" {{ (old('startweek', $schedule->startweek ?? '') == 'Sunday') ? 'selected' : '' }}>Sunday</option>
                            </select>
                        </div>

                        <!-- End Week Input (Dropdown) -->
                        <div>
                            <label for="endweek" class="mt-2 block text-xs sm:text-sm font-medium text-gray-700">End Week</label>
                            <select id="endweek" name="endweek" class="mt-1 text-xs sm:text-sm text-gray-700 block w-full px-2 py-1 sm:px-3 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="" disabled selected>Select here</option>
                                <option value="Monday" {{ (old('endweek', $schedule->endweek ?? '') == 'Monday') ? 'selected' : '' }}>Monday</option>
                                <option value="Tuesday" {{ (old('endweek', $schedule->endweek ?? '') == 'Tuesday') ? 'selected' : '' }}>Tuesday</option>
                                <option value="Wednesday" {{ (old('endweek', $schedule->endweek ?? '') == 'Wednesday') ? 'selected' : '' }}>Wednesday</option>
                                <option value="Thursday" {{ (old('endweek', $schedule->endweek ?? '') == 'Thursday') ? 'selected' : '' }}>Thursday</option>
                                <option value="Friday" {{ (old('endweek', $schedule->endweek ?? '') == 'Friday') ? 'selected' : '' }}>Friday</option>
                                <option value="Saturday" {{ (old('endweek', $schedule->endweek ?? '') == 'Saturday') ? 'selected' : '' }}>Saturday</option>
                                <option value="Sunday" {{ (old('endweek', $schedule->endweek ?? '') == 'Sunday') ? 'selected' : '' }}>Sunday</option>
                            </select>
                        </div>
                            
                        <div>
                            <label for="startmorningtime" class="mt-2 block text-xs sm:text-sm font-medium text-gray-700">Morning Start Time</label>
                            <input type="time" id="startmorningtime" name="startmorningtime" class="mt-1 text-xs sm:text-sm text-gray-700 block w-full px-2 py-1 sm:px-3 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $schedule->startmorningtime ?? '' }}" required>
                        </div>

                        <div>
                            <label for="endmorningtime" class="mt-2 block text-xs sm:text-sm font-medium text-gray-700">Morning End Time</label>
                            <input type="time" id="endmorningtime" name="endmorningtime" class="mt-1 text-xs sm:text-sm text-gray-700 block w-full px-2 py-1 sm:px-3 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $schedule->endmorningtime ?? '' }}" required>
                        </div>

                        <div>
                            <label for="startafternoontime" class="mt-2 block text-xs sm:text-sm font-medium text-gray-700">Afternoon Start Time</label>
                            <input type="time" id="startafternoontime" name="startafternoontime" class="mt-1 text-xs sm:text-sm text-gray-700 block w-full px-2 py-1 sm:px-3 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $schedule->startafternoontime ?? '' }}" required>
                        </div>

                        <div>
                            <label for="endafternoontime" class="mt-2 block text-xs sm:text-sm font-medium text-gray-700">Afternoon End Time</label>
                            <input type="time" id="endafternoontime" name="endafternoontime" class="mt-1 text-xs sm:text-sm text-gray-700 block w-full px-2 py-1 sm:px-3 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $schedule->endafternoontime ?? '' }}" required>
                        </div>

                        <div>
                            <label for="closedday" class="mt-2 block text-xs sm:text-sm font-medium text-gray-700">Closed Day</label>
                            <input type="text" id="closedday" name="closedday" class="mt-1 text-xs sm:text-sm text-gray-700 block w-full px-2 py-1 sm:px-3 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $schedule->closedday ?? '' }}" required>
                        </div>

                        <!-- Other fields (end week, start and end times, closed day) here... -->

                        <div class="flex justify-end mt-2 sm:mt-4">
                            <button type="submit" class="text-xs sm:text-sm mr-2 px-3 py-1 sm:px-4 sm:py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">{{ $schedule ? 'Edit' : 'Add' }}</button>
                            <button type="button" class="text-xs sm:text-sm px-3 py-1 sm:px-4 sm:py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600" id="closeModalButton">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Treatments
        document.addEventListener('DOMContentLoaded', function() {
            // Get elements
            const addBtn = document.getElementById('add-treatment-btn');
            const treatmentForm = document.getElementById('treatment-form');
            const treatmentEmpty = document.getElementById('treatment-empty');
            const cancelBtn = document.getElementById('cancel-btn');

            // Show the form and hide the placeholder content when the + button is clicked
            addBtn.addEventListener('click', function() {
                treatmentEmpty.style.display = 'none';  // Hide the placeholder content
                treatmentForm.classList.remove('hidden');  // Show the form
            });

            // Hide the form and show the placeholder content when the Cancel button is clicked
            cancelBtn.addEventListener('click', function() {
                treatmentEmpty.style.display = 'flex';  // Show the placeholder content again
                treatmentForm.classList.add('hidden');  // Hide the form
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            
            document.querySelectorAll('.edit-link').forEach(function(editLink) {
                editLink.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default behavior of the link

                    var treatmentId = this.getAttribute('data-treatment-id'); // Get the treatment ID
                    var treatmentCard = document.getElementById('treatment-card-' + treatmentId); // Treatment card element
                    var editForm = document.getElementById('edit-treatment-form-' + treatmentId); // Edit form element

                    // Hide the treatment card
                    treatmentCard.classList.add('hidden');

                    // Show the edit form
                    editForm.classList.remove('hidden');
                });
            });

            document.querySelectorAll('.cancel-edit').forEach(function (cancelButton) {
                cancelButton.addEventListener('click', function (event) {
                    var treatmentId = this.getAttribute('data-treatment-id'); // Get the treatment ID
                    var treatmentCard = document.getElementById('treatment-card-' + treatmentId); // Treatment card element
                    var editForm = document.getElementById('edit-treatment-form-' + treatmentId); // Edit form element

                    // Hide the edit form
                    editForm.classList.add('hidden');

                    // Show the treatment card
                    treatmentCard.classList.remove('hidden');

                    // Optionally, reset the form
                    editForm.reset(); // Reset form values to their initial state
                });
            });
        });

        document.getElementById("prev-btn").addEventListener("click", function() {
            document.getElementById("slider").scrollBy({left: -200, behavior: 'smooth'});
        });

        document.getElementById("next-btn").addEventListener("click", function() {
            document.getElementById("slider").scrollBy({left: 200, behavior: 'smooth'});
        });

        // Footer
        document.addEventListener('DOMContentLoaded', function () {
                    
            const modal = document.getElementById('scheduleModal');
            const openModalButton = document.getElementById('openModalButton');
            const closeModalButton = document.getElementById('closeModalButton');
                    
            // Open the modal when the trigger button is clicked
            openModalButton.addEventListener('click', function () {
                modal.classList.remove('hidden');  // Make the modal visible
                    modal.classList.add('flex');       // Use flexbox to center the modal
            });

            // Close the modal when the 'Close' button is clicked
            closeModalButton.addEventListener('click', function () {
                modal.classList.add('hidden');  // Hide the modal again
                modal.classList.remove('flex');
            });
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