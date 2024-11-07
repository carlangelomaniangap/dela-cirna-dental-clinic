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
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Total Users in Your Clinic</h2>
                <div class="flex items-center justify-center mb-4 p-4 bg-blue-200 rounded-lg">
                    <i class="fas fa-users fa-3x text-blue-600 mr-4"></i>
                    <p class="text-3xl font-bold text-blue-600">{{ $userCount }}</p>
                </div>
                <p class="text-gray-500">Keep track of registered users in your clinic.</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Recent Registrations</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-200 p-4 rounded-lg shadow flex items-center">
                        <i class="fas fa-user-friends fa-2x text-green-600 mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-green-600">Patients</h3>
                            <p class="text-3xl font-bold text-green-700">{{ $patientCount }}</p>
                        </div>
                    </div>
                    <div class="bg-indigo-200 p-4 rounded-lg shadow flex items-center">
                        <i class="fas fa-user-graduate fa-2x text-indigo-600 mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-indigo-600">Dentistry Students</h3>
                            <p class="text-3xl font-bold text-indigo-700">{{ $dentistrystudentCount }}</p>
                        </div>
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

    <div class="p-6 pt-0">
        <div class="bg-white shadow-lg rounded-lg p-4 sm:p-6 mb-6">

            <div class="flex flex-col sm:flex-row items-center justify-between mb-4">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Inventory</h1>
                <button id="createInventoryButton" class="mt-2 sm:mt-0 bg-blue-600 hover:bg-blue-700 text-white transition duration-300 px-4 py-2 rounded max-w-xs font-semibold">Add Item</button>
            </div>

            <div class="flex justify-center">
                <table class="min-w-full mt-4 bg-white shadow-lg rounded-lg">
                    <thead class="bg-gray-200 text-gray-600 uppercase font-semibold text-xs sm:text-sm lg:text-base text-left">
                        <tr>
                            <th class="px-4 sm:px-6 py-3">Item Name</th>
                            <th class="px-4 sm:px-6 py-3">Quantity</th>
                            <th class="px-4 sm:px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($inventories->isEmpty())
                            <tr>
                                <td class="px-4 sm:px-6 py-4 text-gray-600" colspan="3">No items found.</td>
                            </tr>
                        @else
                            @foreach ($inventories as $inventory)
                                <tr class="hover:bg-gray-100 transition duration-300">
                                    <td class="border-b px-4 sm:px-6 py-4 text-gray-800 text-sm sm:text-base lg:text-lg">{{ $inventory->item_name }}</td>
                                    <td class="border-b px-4 sm:px-6 py-4 text-gray-800 text-sm sm:text-base lg:text-lg">{{ $inventory->quantity }}</td>
                                    <td class="border-b px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <div class="relative inline-block text-left">
                                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none dropdown-button" aria-haspopup="true" aria-expanded="false" data-dropdown-id="dropdown-{{ $inventory->id }}">
                                                <span class="text-gray-600"><i class="fa-solid fa-ellipsis"></i></span>
                                            </button>

                                            <div class="absolute right-0 z-10 mt-2 w-28 lg:w-48 px-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden dropdown-menu" id="dropdown-{{ $inventory->id }}" role="menu" aria-orientation="vertical">
                                                <div class="py-1" role="none">
                                                    <a href="{{ route('inventory.show', $inventory->id) }}" class="block px-4 py-2 text-sm sm:text-base text-gray-700 hover:bg-gray-100 hover:rounded-lg" role="menuitem"><i class="fas fa-history"></i> History</a>
                                                    <button class="editItemButton block w-full text-left px-4 py-2 text-sm sm:text-base text-blue-700 hover:bg-blue-100 hover:rounded-lg" data-id="{{ $inventory->id }}" data-item_name="{{ $inventory->item_name }}" data-quantity="{{ $inventory->quantity }}" role="menuitem"><i class="fa-solid fa-pen"></i> Edit</button>
                                                    <div class="h-px bg-gray-300 my-1"></div>
                                                    <form method="post" action="{{ route('inventory.destroy', $inventory->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm sm:text-base text-red-700 hover:bg-red-100 hover:rounded-lg" onclick="return confirm('Are you sure you want to delete this item?');" role="menuitem"><i class="fa-regular fa-trash-can"></i> Delete</button>
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
    </div>

    <!-- Modal for Create/Edit Item -->
    <div id="inventoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
        
        <div class="bg-white p-4 rounded-lg shadow-md z-10">
            <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-5">
                <h4 class="text-lg font-bold" id="modalTitle">Add Item</h4>
            </div>
            <form id="inventoryForm" action="{{ route('inventory.store') }}" method="POST">
                <input type="hidden" name="dentalclinic_id" value="{{ Auth::user()->dentalclinic_id }}">
                    
                @csrf
                    
                <input type="hidden" name="_method" id="methodInput" value="POST">

                <div>
                    <label for="item_name" class="block">Item Name</label>
                    <input type="text" name="item_name" id="item_name" class="w-full rounded-lg focus:ring-2 shadow-sm" required>
                </div>
                <div id="quantityContainer" class="mt-2">
                    <label for="quantity" class="block">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="w-full rounded-lg focus:ring-2 shadow-sm">
                </div>
                <div id="actionContainer" class="mt-2 hidden">
                    <label for="action" class="block">Action</label>
                    <select name="action" id="action" class="w-full py-2 px-3 rounded-lg focus:ring-2 shadow-sm">
                        <option value="" disabled selected>Select here</option>
                        <option value="add">Add</option>
                        <option value="subtract">Subtract</option>
                    </select>
                </div>
                <div class="mt-4 text-right">
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300">Save</button>
                    <button type="button" id="closeModal" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButtons = document.querySelectorAll('.dropdown-button');
            const dropdownHeight = 155; // Set your fixed dropdown height here

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

                    // Toggle the clicked dropdown
                    const isHidden = dropdownMenu.classList.contains('hidden');
                    dropdownMenu.classList.toggle('hidden', !isHidden);

                    // Position the dropdown
                    if (isHidden) {
                        if (spaceBelow >= dropdownHeight) {
                            // Show below if there's enough space
                            dropdownMenu.style.top = '100%'; // Default position
                        } else if (spaceAbove >= dropdownHeight) {
                            // Show above if there's not enough space below
                            dropdownMenu.style.top = `-${dropdownHeight}px`; // Adjust for spacing
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



        const createInventoryButton = document.getElementById('createInventoryButton');
        const editInventoryButton = document.querySelectorAll('.editItemButton');
        const inventoryModal = document.getElementById('inventoryModal');
        const closeModalButton = document.getElementById('closeModal');
        const inventoryForm = document.getElementById('inventoryForm');
        const methodInput = document.getElementById('methodInput');

        createInventoryButton.addEventListener('click', () => {
            inventoryModal.classList.remove('hidden');
            document.getElementById('modalTitle').innerText = 'Add Item';
            methodInput.value = 'POST';
            inventoryForm.action = "{{ route('inventory.store') }}";
            inventoryForm.reset();

            document.getElementById('actionContainer').classList.add('hidden');
        });

        editInventoryButton.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const item_name = button.dataset.item_name;
                const quantity = button.dataset.quantity;

                inventoryModal.classList.remove('hidden');
                document.getElementById('modalTitle').innerText = 'Edit Inventory';
                methodInput.value = 'PUT';
                inventoryForm.action = `{{ url('admin/inventory') }}/${id}`;
                document.getElementById('item_name').value = item_name;
                document.getElementById('quantity').value = '';

                document.getElementById('actionContainer').classList.remove('hidden');
            });
        });

        closeModalButton.addEventListener('click', () => {
            inventoryModal.classList.add('hidden');
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
