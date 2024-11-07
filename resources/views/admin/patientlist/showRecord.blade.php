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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-users"></i> Patient List / {{ $patientlist->user->name }}</h4>
    </div>

    @if(session('success') || $errors->any())
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="relative p-4 w-full max-w-md">
                <div class="relative p-5 text-center bg-white rounded-lg shadow">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center" onclick="this.closest('.fixed').style.display='none'">
                        <i class="fa-solid fa-xmark text-lg"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                        <i class="fa-solid fa-check text-green-500 text-2xl"></i>
                        <span class="sr-only">Success</span>
                    </div>

                    @if(session('success'))
                        <p class="mb-4 text-lg font-semibold text-gray-900">{{ session('success') }}</p>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="mb-4 text-lg font-semibold text-red-600">{{ $error }}</p>
                        @endforeach
                    @endif

                    <button type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300" onclick="this.closest('.fixed').style.display='none'">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-5 min-h-screen">
        
        <!-- Patient details -->
        <div class="bg-white shadow-md p-5 rounded-xl">
            <h1 class="text-lg lg:text-xl font-bold">Patient Details</h1>
            <div class="mt-5">
                <ul class="text-sm sm:text-base text-gray-700 list-disc pl-5">
                    <li>
                        <span class="font-semibold">Name:</span> <span>{{ $patientlist->user->name }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Gender:</span> <span>{{ $patientlist->user->gender }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Birthday:</span> <span>{{ date('F j, Y', strtotime($patientlist->user->birthday)) }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Age:</span> <span>{{ $patientlist->user->age }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Address:</span> <span>{{ $patientlist->user->address }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Phone:</span> <span>{{ $patientlist->user->phone }}</span>
                    </li>
                    <li>
                        <span class="font-semibold">Email:</span> <span>{{ $patientlist->user->email }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Patient notes -->
        <div class="bg-white shadow-md p-5 rounded-xl">
            
            <div class="flex justify-between">
                <h1 class="text-lg lg:text-xl font-bold">Notes</h1>
                <!-- Button to open modal -->
                <button id="openModalBtn" class="px-4 py-1 text-xs lg:text-base rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300">Add Notes</button>
            </div>

            <!-- Display Notes -->
            <div class="flex flex-col space-y-2 max-h-48 overflow-y-auto mt-5 p-2 border border-gray-300 rounded-lg">
                @if($notes->isEmpty())
                    <p class="text-gray-800">No notes found.</p>
                @else    
                    @foreach ($notes as $note)
                        <div class="note-item p-4 bg-gray-50 rounded-md border border-gray-200">
                            <form action="{{ route('admin.note.update', [$patientlist->id, $note->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <p class="justify text-gray-800 cursor-pointer">{{ $note->note }}</p>
                                <p class="hidden full-text text-gray-800 cursor-pointer">{{ $note->note }}</p>
                                <textarea class="hidden edit-input w-full text-gray-800" name="note" onblur="this.form.submit()">{{ $note->note }}</textarea>
                                <button type="button" class="hidden save-btn px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white transition duration-300 rounded text-xs sm:text-sm mt-1" onclick="saveEdit(event)">Save</button>
                                <button type="button" class="hidden cancel-btn px-2 py-1 bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300 rounded text-xs sm:text-sm mt-1" onclick="cancelEdit(event)">Cancel</button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Modal Structure -->
            <div id="notesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                
                <div class="bg-white p-4 rounded-lg shadow-md z-10 max-w-md w-full mx-4 sm:mx-auto">
                    <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white rounded-lg mb-5">
                        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold">Add Note</h4>
                    </div>
                    <form method="post" action="{{ route('admin.note.store', $patientlist->id) }}">
                        @csrf

                        <input type="hidden" name="patientlist_id" value="{{ $patientlist->id }}">
                        
                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                            <textarea id="note" name="note" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Type your notes here..." required></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 text-xs lg:text-base rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300 mr-2">Save</button>
                            <button type="button" id="closeModalBtn" class="px-4 py-2 text-xs lg:text-base rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Patient records -->
        <div class="col-span-1 lg:col-start-3 lg:row-span-2 bg-white shadow-md p-5 rounded-xl">
            
            <div class="flex justify-between mb-4">
                <h1 class="text-lg lg:text-xl font-bold"><i class="fa-regular fa-folder-open"></i> List of Records</h1>
                <button id="openModal" class="px-4 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300"><i class="fa-solid fa-file-circle-plus"></i></a>
            </div>

            <div id="recordsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                <div class="bg-white p-4 rounded-lg shadow-md z-10 max-w-md w-full mx-4 sm:mx-auto">
                    <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white rounded-lg mb-5">
                        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold">Add Record</h4>
                    </div>
                    <form method="post" action="{{ route('admin.record.store', $patientlist->id) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="patientlist_id" value="{{ $patientlist->id }}">
                        
                        <div class="mb-3">
                            <label for="file" class="font-semibold">File</label>
                            <input type="file" class="w-full pb-5 " id="file" name="file" required>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300">Upload File</button>
                            <button type="button" id="closeModal" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300">Cancel</button>
                        </div>
                    </form>
                </div>
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
                                        <form action="{{ route('admin.record.update', [$patientlist->id, $record->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <p class="truncate overflow-hidden overflow-ellipsis whitespace-nowrap text-gray-800 cursor-pointer">{{ $record->file }}</p>
                                            <p class="hidden full-text text-gray-800 cursor-pointer">{{ $record->file }}</p>
                                            <input type="text" class="hidden edit-input w-full text-gray-800" name="file" value="{{ pathinfo($record->file, PATHINFO_FILENAME) }}" onblur="this.form.submit()" />
                                            <button type="button" class="hidden save-btn px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white transition duration-300 rounded text-xs sm:text-sm mt-1" onclick="saveEdit(event)">Save</button>
                                            <button type="button" class="hidden cancel-btn px-2 py-1 bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300 rounded text-xs sm:text-sm mt-1" onclick="cancelEdit(event)">Cancel</button>
                                        </form>
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
                                                    <a href="{{ route('admin.downloadRecord', [$patientlist->id, $record->id]) }}" class="block px-4 py-2 text-sm sm:text-base text-gray-700 hover:bg-gray-100 hover:rounded-lg"><i class="fa-solid fa-download"></i> Download</a>
                                                    <div class="h-px bg-gray-300 my-1"></div>
                                                    <form method="post" action="{{ route('admin.deleteRecord', [$patientlist->id, $record->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm sm:text-base text-red-700 hover:bg-red-100 hover:rounded-lg" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa-regular fa-trash-can"></i> Delete</button>
                                                    </form>
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

        <!-- Patient upcoming appointment -->
        <div class="row-start-2 col-span-1 md:col-span-2 bg-white shadow-md p-5 rounded-xl">
            <h1 class="text-lg lg:text-xl font-bold">Upcoming Appointment</h1>
            <div class="space-y-2 mt-5 max-h-32 overflow-y-auto p-2 border border-gray-300 rounded-lg">
                @if($calendars->isEmpty())
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <p class="text-gray-800">No appointment found.</p>
                    </div>
                @else
                    @foreach ($calendars as $calendar)
                        <div class="border border-gray-200 rounded-lg p-2 flex flex-col sm:flex-row justify-between items-start bg-gray-50 hover:bg-gray-100 transition duration-200">
                            <div class="flex-grow mb-4 sm:mb-0">
                                <p class="text-base lg:text-lg text-gray-800">
                                    <strong>{{ date('F j, Y', strtotime($calendar->appointmentdate)) }}</strong> at <strong>{{ date('g:i A', strtotime($calendar->appointmenttime)) }}</strong>
                                </p>
                                <p class="text-sm lg:text-base text-gray-600">
                                    <span>{{ $calendar->user->name }}</span>
                                </p>
                            </div>
                            <div class="text-sm lg:text-base text-right">
                                <p class="text-sm lg:text-base text-gray-500">
                                    Concern: <span>{{ $calendar->concern }}</span>
                                </p>
                                <span class="text-gray-500">Status:</span>
                                <span class="font-semibold {{ $calendar->status == 'Approved' ? 'text-green-600' : ($calendar->status == 'Pending' ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $calendar->status }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>

    </div>

    <script>
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const notesModal = document.getElementById('notesModal');

        openModalBtn.addEventListener('click', () => {
            notesModal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            notesModal.classList.add('hidden');
        });

        // Close modal if clicking outside the modal-content
        window.addEventListener('click', (event) => {
            if (event.target === notesModal) {
                notesModal.classList.add('hidden');
            }
        });

        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');
        const recordsModal = document.getElementById('recordsModal');

        openModal.addEventListener('click', () => {
            recordsModal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            recordsModal.classList.add('hidden');
        });

        // Close modal if clicking outside the modal-content
        window.addEventListener('click', (event) => {
            if (event.target === recordsModal) {
                recordsModal.classList.add('hidden');
            }
        });

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

    <script> // Edit file name
        // Enable edit mode
        function enableEdit(event) {
            const target = event.currentTarget;
            const input = target.nextElementSibling.nextElementSibling; // The input field

            // additional
            const saveBtn = input.nextElementSibling; // The Save button
            const cancelBtn = input.nextElementSibling.nextElementSibling; // The Cancel button

            target.classList.add('hidden'); // Hide truncated text
            target.nextElementSibling.classList.add('hidden'); // Hide full text
            input.classList.remove('hidden'); // Show input field
            input.focus(); // Focus the input field

            // Select the entire text in the input
            input.select();

            // additional
            saveBtn.classList.remove('hidden'); // Show the save button
            cancelBtn.classList.remove('hidden'); // Show the cancel button
        }

        // Save edited text
        function saveEdit(event) {
            const input = event.currentTarget;
            const newText = input.value;

            // You may want to save the newText to the database here using AJAX or similar

            // Hide the input and show the truncated text again
            const truncatedText = input.previousElementSibling.previousElementSibling; // The truncated p
            const fullText = input.previousElementSibling; // The full text p

            truncatedText.textContent = newText; // Update truncated text
            fullText.textContent = newText; // Update full text
            truncatedText.classList.remove('hidden'); // Show truncated text
            fullText.classList.add('hidden'); // Hide full text
            input.classList.add('hidden'); // Hide input field

            input.form.submit(); // Submit the form

            // additional
            event.currentTarget.classList.add('hidden'); // Hide the save button
            input.nextElementSibling.classList.add('hidden'); // Hide the cancel button
        }

        // additional
        // Cancel edit mode
        function cancelEdit(event) {
            const input = event.currentTarget.previousElementSibling; // The textarea
            const displayedText = input.previousElementSibling; // The displayed <p>

            displayedText.classList.remove('hidden'); // Show updated text
            input.classList.add('hidden'); // Hide input field
            event.currentTarget.classList.add('hidden'); // Hide the cancel button
            input.nextElementSibling.classList.add('hidden'); // Hide the save button
        }

        // Close full text if clicking outside
        document.addEventListener('click', function (event) {
            const fullTexts = document.querySelectorAll('.full-text:not(.hidden)');
            fullTexts.forEach(fullText => {
                const truncatedText = fullText.previousElementSibling;
                if (!truncatedText.contains(event.target) && !fullText.contains(event.target)) {
                    fullText.classList.add('hidden');
                    truncatedText.classList.remove('hidden');

                    // additional
                    const saveBtn = input.nextElementSibling; // Save button
                    const cancelBtn = saveBtn.nextElementSibling; // Cancel button
                    saveBtn.classList.add('hidden'); // Hide the save button
                    cancelBtn.classList.add('hidden'); // Hide the cancel button
                }
            });
        });

        document.addEventListener('keydown', function(event) {
            if (event.target.classList.contains('edit-input') && event.key === 'Enter') {
                saveEdit(event.target);
            }
        });

        // Enable edit on double-click for the truncated text
        document.querySelectorAll('.truncate').forEach(item => {
            item.addEventListener('dblclick', enableEdit);
        });

        // Enable edit on double-click for the notes
        document.querySelectorAll('p.justify').forEach(item => {
            item.addEventListener('dblclick', enableEdit);
        });
    </script>
    
</body>
</html>

@section('title')
    Record
@endsection

</x-app-layout>