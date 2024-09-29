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
        <h4><i class="fa-solid fa-users"></i> Patient List / {{ $patientlist->name }}</h4>
    </div>

    <div class="grid grid-cols-3 grid-rows-2 gap-4 p-5 max-h-screen">
        
        <!-- Patient details -->
        <div class="col-start-1 bg-white shadow-md p-5 rounded-xl h-[250px]">
            <h1 class="text-xl font-bold border-b-2">Patient Details</h1>
            <div class="max-h-96 overflow-y-auto oveflow-x-auto">
                <table class="min-w-full bg-white text-left rtl:text-right mb-4">
                    <thead class="whitespace-nowrap overflow-hidden">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $patientlist->name }}</td>
                        </tr>
                        <tr>
                            <th>Birthday:</th>
                            <td>{{ $patientlist->birthday }}</td>
                        </tr>
                        <tr>    
                            <th>Age:</th>
                            <td>{{ $patientlist->age }}</td>
                        </tr>
                        <tr>
                            <th>Gender:</th>
                            <td>{{ $patientlist->gender }}</td>
                        </tr>
                        <tr>
                            <th>Phone No:</th>
                            <td>{{ $patientlist->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $patientlist->address }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $patientlist->email }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Patient notes -->
        <div class="col-start-2 bg-white shadow-md p-5 rounded-xl h-[250px]">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p style="color: red">{{ $error }}</p>
                @endforeach
            @endif

            <div class="flex justify-between">
                <h1 class="text-xl font-bold">Notes</h1>
                <!-- Button to open modal -->
                <button id="openModalBtn" class="px-4 py-1 bg-blue-500 text-white rounded">Add Notes</button>
            </div>

            <!-- Display Notes -->
            <div class="max-h-50 overflow-y-auto overflow-x-auto">
                <table class="min-w-full">
                    <tbody class="flex items-center justify-center text-justify m-5">
                        @foreach ($notes as $note)
                            <tr>
                                <td class="overflow-hidden">{{ $note->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal Structure -->
            <div id="notesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <div class="bg-[#4b9cd3;] rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-10">
                        <h4>Add Note</h4>
                    </div>
                    <form method="post" action="{{ route('admin.note.store', $patientlist->id) }}">
                        @csrf

                        <input type="hidden" name="patientlist_id" value="{{ $patientlist->id }}">
                        
                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                            <textarea id="note" name="note" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter note" required></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save Notes</button>
                            <button type="submit" id="closeModalBtn" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Patient records -->
        <div class="col-start-3 row-span-2 bg-white shadow-md p-5 rounded-xl">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p style="color: red">{{ $error }}</p>
                @endforeach
            @endif

            <div class="flex justify-between mb-4">
                <h1 class="text-2xl font-bold"><i class="fa-regular fa-folder-open"></i> List of Records</h1>
                <button id="openModal" class="px-4 py-1 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-solid fa-file-circle-plus"></i></a>
            </div>

            <div id="recordsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <div class="bg-[#4b9cd3;] rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-10">
                        <h4>Add Record</h4>
                    </div>
                    <form method="post" action="{{ route('admin.record.store', $patientlist->id) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="patientlist_id" value="{{ $patientlist->id }}">
                        
                        <div class="mb-3">
                            <label for="file" class="font-semibold">File</label>
                            <input type="file" class="w-full pb-5 " id="file" name="file" required>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white">Upload File</button>
                            <button type="submit" id="closeModal" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex justify-between">
                <h1 class="text-xl font-bold">Files</h1>
                <h1>Total Files: {{ $count }}</h1>
            </div>
            
            <div class="max-h-96 overflow-y-auto overflow-x-auto border-t-2 border-b">
                
                <table class="min-w-full bg-white text-left rtl:text-right">
                    <tbody>
                        @foreach ($records as $record)
                            <tr class="relative group bg-white border-b hover:bg-gray-100">
                                <td class="py-4 px-4 whitespace-nowrap overflow-hidden cursor-pointer">{{ $record->file }}</td>
                                <td class="py-4 whitespace-nowrap overflow-hidden">
                                    <div class="bg-white px-4 py-2 rounded-lg shadow-md absolute left-1/2 top-1/2 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex space-x-2">
                                        <a href="{{ route('admin.downloadRecord', [$patientlist->id, $record->id]) }}" class="px-2 text-blue-800"><i class="fa-solid fa-download text-lg"></i></a>
                                        <a href="{{ route('admin.updateRecord', [$patientlist->id, $record->id]) }}" class="px-2 text-gray-800"><i class="fa-solid fa-pen text-lg"></i></a>
                                        <form method="post" action="{{ route('admin.deleteRecord', [$patientlist->id, $record->id]) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 text-red-800" onclick="return confirm('Are you sure you want to delete this patient?')"><i class="fa-regular fa-trash-can text-lg"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Patient upcoming appointment -->
        <div class="row-start-2 col-span-2 bg-white shadow-md p-5 rounded-xl h-[250px]">
            <h1 class="text-xl font-bold border-b-2">Upcoming Appointment</h1>
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-2">Appointment Date</th>
                        <th scope="col" class="px-4 py-2">Appointment Time</th>
                        <th scope="col" class="px-4 py-2">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($calendars as $calendar)
                        <tr>
                            <td class="px-4">{{$calendar->appointmentdate}}</td>
                            <td class="px-4">{{$calendar->appointmenttime}}</td>
                            <td class="px-4">{{$calendar->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    </script>
</body>
</html>

@section('title')
    Record
@endsection

</x-app-layout>