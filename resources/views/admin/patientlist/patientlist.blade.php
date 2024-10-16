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
        <h4><i class="fa-solid fa-users"></i> Patient List</h4>
    </div>
    
    <div class="actions px-6 py-4 flex justify-between items-center">
        <a href="{{ route('admin.patient.create') }}" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-solid fa-user-plus"></i> New</a>

        <form action="{{ route('admin.search') }}" method="GET">

            <div class="relative w-full">
                <input type="text" name="query" placeholder="Search" class="w-full h-10 px-3 rounded-full focus:ring-2 border border-gray-300 focus:outline-none focus:border-blue-500">
                <button type="submit" class="absolute top-0 end-0 p-2.5 pr-3 text-sm font-medium h-full text-white bg-blue-700 rounded-e-full border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </form>
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

    <div class="p-6">
        <table class="min-w-full mt-4 bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-white text-gray-600 uppercase font-semibold text-sm text-left border-b-2">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Gender</th>
                    <th class="px-6 py-4">Age</th>
                    <th class="px-6 py-4">Phone No.</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($patientlist->isEmpty())
                    <tr>
                        <td class="px-6 py-4 text-gray-600">No patients found.</td>
                    </tr>
                @else
                    @foreach ($patientlist as $patient)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $patient->name }}</td>
                            <td class="px-6 py-4">{{ $patient->gender }}</td>
                            <td class="px-6 py-4">{{ $patient->age }}</td>
                            <td class="px-6 py-4">{{ $patient->phone }}</td>
                            <td class="px-6 py-4">{{ $patient->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.showRecord', $patient->id) }}" class="px-4 py-2 rounded text-blue-800 hover:bg-blue-200 transition duration-300"><i class="fa-solid fa-folder-closed"></i> Records</a>
                                <a href="{{ route('admin.updatePatient', $patient->id) }}" class="px-4 py-2 rounded text-gray-800 hover:bg-gray-200 transition duration-300"><i class="fa-solid fa-pen"></i> Edit</a>
                                
                                <a href="{{ route('admin.deletePatient', $patient->id) }}" class="px-4 py-2 rounded text-red-800 hover:bg-red-200 transition duration-300" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this patient?')) { document.getElementById('delete-patient-form').submit(); }"><i class="fa-regular fa-trash-can"></i> Delete</a>
                                <!-- hidden form for csrf -->
                                <form id="delete-patient-form" method="post" action="{{ route('admin.deletePatient', $patient->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="mt-4">
            {{ $patientlist->links() }}
        </div>

    </div>

</body>
</html>

@section('title')
    Patient List
@endsection

</x-app-layout>