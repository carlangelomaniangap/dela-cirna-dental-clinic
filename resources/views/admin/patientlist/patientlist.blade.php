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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-users"></i> Patient List</h4>
    </div>
    
    <div class="px-6 py-4 flex justify-between items-center">
        <a href="{{ route('admin.patient.create') }}" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300 text-xs sm:text-sm lg:text-base font-semibold"><i class="fa-solid fa-user-plus"></i> New</a>

        <form action="{{ route('admin.search') }}" method="GET">
            <div class="relative w-full">
                <input type="text" name="query" placeholder="Search" class="w-full h-10 text-xs sm:text-sm lg:text-base px-3 rounded-full focus:ring-2 border border-gray-100 focus:outline-none focus:border-blue-500 transition-shadow duration-300 shadow-sm hover:shadow-md">
                <button type="submit" class="absolute top-0 end-0 p-2.5 pr-3 text-sm font-medium h-full text-white bg-blue-700 rounded-e-full border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
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

    <div class="p-6 pt-0">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if($patientlist->isEmpty())
                <div class="col-span-1 bg-gray-50 p-4 rounded-lg shadow-lg text-center">
                    <p class="text-gray-600">No patients found.</p>
                </div>
            @else
                @foreach ($patientlist as $patient)
                    <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition duration-200">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm sm:text-base lg:text-lg font-semibold text-gray-800">{{ $patient->name }}</p>
                                <ul class="text-sm sm:text-base text-gray-600 list-disc pl-5">
                                    <li>
                                        <span class="font-semibold">Gender:</span> <span>{{ $patient->gender }}</span>
                                    </li>
                                    <li>
                                        <span class="font-semibold">Birthday:</span> <span>{{ date('F j, Y', strtotime($patient->birthday)) }}</span>
                                    </li>
                                    <li>
                                        <span class="font-semibold">Age:</span> <span>{{ $patient->age }}</span>
                                    </li>
                                    <li>
                                        <span class="font-semibold">Address:</span> <span>{{ $patient->address }}</span>
                                    </li>
                                    <li>
                                        <span class="font-semibold">Phone:</span> <span>{{ $patient->phone }}</span>
                                    </li>
                                    <li>
                                        <span class="font-semibold">Email:</span> <span>{{ $patient->email }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="relative inline-block text-left">
                                <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none dropdown-button" aria-haspopup="true" aria-expanded="false" data-dropdown-id="dropdown-{{ $patient->id }}">
                                    <span class="text-gray-600"><i class="fa-solid fa-ellipsis"></i></span>
                                </button>

                                <div class="absolute right-0 z-10 mt-2 w-32 lg:w-48 px-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden dropdown-menu" id="dropdown-{{ $patient->id }}" role="menu" aria-orientation="vertical">
                                    <div class="py-1" role="none">
                                        <a href="{{ route('admin.showRecord', $patient->id) }}" class="block px-4 py-2 text-sm sm:text-base text-gray-700 hover:bg-gray-100 hover:rounded-lg"><i class="fa-solid fa-folder-closed"></i> Records</a>
                                        <a href="{{ route('admin.updatePatient', $patient->id) }}" class="block px-4 py-2 text-sm sm:text-base text-blue-700 hover:bg-blue-100 hover:rounded-lg"><i class="fa-solid fa-pen"></i> Edit</a>
                                        <div class="h-px bg-gray-300 my-1"></div>
                                        <form method="post" action="{{ route('admin.deletePatient', $patient->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm sm:text-base text-red-700 hover:bg-red-100 hover:rounded-lg" onclick="return confirm('Are you sure you want to delete this patient?')"><i class="fa-regular fa-trash-can"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-4">
            {{ $patientlist->links() }}
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButtons = document.querySelectorAll('.dropdown-button');

            dropdownButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.stopPropagation(); // Prevents event from bubbling up to the window

                    const dropdownId = this.getAttribute('data-dropdown-id');
                    const dropdownMenu = document.getElementById(dropdownId);

                    // Close all other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (menu !== dropdownMenu) {
                            menu.classList.add('hidden');
                        }
                    });

                    // Toggle the clicked dropdown
                    dropdownMenu.classList.toggle('hidden');
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
    Patient List
@endsection

</x-app-layout>