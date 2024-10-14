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

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
                            <td class="px-6 py-4">
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
            
        <!-- pagination here -->
        @if ($patientlist->lastPage() > 1)
            <ul class="pagination mt-8 mb-8 flex items-center justify-center">
                <!-- Previous Page Link -->
                @if ($patientlist->onFirstPage())
                <li class="page-item disabled mx-1" aria-disabled="true">
                    <span class="page-link text-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" aria-hidden="true">&laquo;</span>
                </li>
                @else
                    <li class="page-item">
                        <a class="page-link text-blue-500 hover:text-white hover:bg-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" href" href="{{ $patientlist->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                    </li>
                @endif

                <!-- Pagination Elements -->
                @for ($i = 1; $i <= $patientlist->lastPage(); $i++)
                    @if ($i == $patientlist->currentPage())
                        <li class="page-item active mx-1" aria-current="page"><span class="page-link text-white px-4 py-2 rounded-lg bg-blue-500">{{ $i }}</span></li>
                    @else
                        <li class="page-item mx-1"><a class="page-link text-blue-500 hover:text-white hover:bg-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" href="{{ $patientlist->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                <!-- Next Page Link -->
                @if ($patientlist->hasMorePages())
                    <li class="page-item mx-1">
                        <a class="page-link text-blue-500 hover:text-white hover:bg-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" href="{{ $patientlist->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link text-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" aria-hidden="true">&raquo;</span>
                    </li>
                @endif
            </ul>
        @endif
    </div>

</body>
</html>

@section('title')
    Patient List
@endsection

</x-app-layout>