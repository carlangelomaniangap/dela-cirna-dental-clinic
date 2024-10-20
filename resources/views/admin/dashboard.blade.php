<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div class="bg-[#4b9cd3;] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 text-white text-2xl font-semibold">
        <h4>{{ __('Dashboard') }}</h4>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6 h-46">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Today's Appointments</h2>
                
                <div class="flex items-center justify-center bg-blue-200 rounded-lg p-4 mb-4">
                    <i class="fas fa-calendar-check fa-3x text-blue-600 mr-4"></i>
                    <p class="text-4xl font-bold text-blue-600">{{ $todayAppointments->count() }}</p>
                </div>

                @if($todayAppointments->count() > 0)
                    <div class="mt-4 overflow-hidden rounded-lg shadow">
                        <div class="max-h-32 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="text-left text-xs font-medium text-gray-600 uppercase tracking-wider py-2 px-2">Time</th>
                                        <th class="text-left text-xs font-medium text-gray-600 uppercase tracking-wider py-2 px-2">Patient Name</th>
                                        <th class="text-left text-xs font-medium text-gray-600 uppercase tracking-wider py-2 px-2">Concern</th>
                                        <th class="text-left text-xs font-medium text-gray-600 uppercase tracking-wider py-2 px-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($todayAppointments as $appointment)
                                        <tr>
                                            <td class="text-sm text-gray-500 py-2 px-2">{{ \Carbon\Carbon::parse($appointment->appointmenttime)->format('g:i A') }}</td>
                                            <td class="text-sm text-gray-500 py-2 px-2">{{ $appointment->name }}</td>
                                            <td class="text-sm text-gray-500 py-2 px-2">{{ $appointment->concern ?? 'Not specified' }}</td>
                                            <td class="text-sm text-gray-500 py-2 px-2">{{ $appointment->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p class="mt-4 text-sm text-gray-500 text-center">No appointments scheduled for today.</p>
                @endif
            </div>



            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Appointment Status Overview</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-200 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-blue-500 text-white rounded-full p-3 mr-3">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-blue-700">Approved</h3>
                                <p class="text-3xl font-bold text-blue-800">{{ $approvedAppointments }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-200 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-orange-500 text-white rounded-full p-3 mr-3">
                                <i class="fas fa-hourglass-half fa-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-orange-700">Pending</h3>
                                <p class="text-3xl font-bold text-orange-800">{{ $pendingAppointments }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-center text-gray-600 text-sm mt-4">Stay organized and on top of your appointments!</p>
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

    <div class="px-6">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">

            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold">Inventory</h1>
                <button id="createInventoryButton" class="bg-blue-500 text-white px-4 py-2 rounded">Add Item</button>
            </div>

            <table class="min-w-full mt-4 bg-white shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-gray-200 text-gray-600 uppercase font-semibold text-sm text-left">
                    <tr>
                        <th class="px-6 py-3">Item Name</th>
                        <th class="px-6 py-3">Quantity</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($inventories->isEmpty())
                        <tr>
                            <td class="px-6 py-4 text-gray-600">No items found.</td>
                        </tr>
                    @else
                        @foreach ($inventories as $inventory)
                            <tr class="hover:bg-gray-100 transition duration-300">
                                <td class="border-b px-6 py-4 text-gray-800">{{ $inventory->item_name }}</td>
                                <td class="border-b px-6 py-4 text-gray-800">{{ $inventory->quantity }}</td>
                                <td class="border-b px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('inventory.show', $inventory->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">History</a>
                                    <button class="editItemButton bg-yellow-500 text-white px-4 py-2 rounded transition duration-200 hover:bg-yellow-600" data-id="{{ $inventory->id }}" data-item_name="{{ $inventory->item_name }}" data-quantity="{{ $inventory->quantity }}">
                                        Edit
                                    </button>
                                    
                                    <form action="{{ route('inventory.destroy', $inventory->id) }}" class="inline" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded transition duration-200 hover:bg-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Create/Edit Item -->
    <div id="inventoryModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        
        <div class="absolute inset-0 bg-black opacity-50"></div>

            <div class="bg-white p-4 rounded-lg shadow-md z-10">
                <div class="bg-[#4b9cd3;] rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-5">
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
                        <select name="action" id="action" class="w-full rounded-lg focus:ring-2 shadow-sm">
                            <option value="" disabled selected>Select here</option>
                            <option value="add">Add</option>
                            <option value="subtract">Subtract</option>
                        </select>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white">Save</button>
                        <button type="button" id="closeModal" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Cancel</button>
                    </div>
                </form>
            </div>
    </div>

    <script>
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
