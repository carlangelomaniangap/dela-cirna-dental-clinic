<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-lg">Welcome, {{ Auth::user()->name }}!</p>
                    <p class="text-sm text-gray-500">You are logged in as an admin.</p>
                </div>
            </div>
        </div>
    </div> -->

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-700">Total Users</h2>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $userCount }}</p>
                <div class="mt-4">
                    <p class="text-gray-500">Keep track of registered users in the system.</p>
                </div>
            </div>

            <!-- Registration Breakdown -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Recent Registrations</h2>
                <ul class="list-disc list-inside">
                    <li class="text-green-500">Patient: {{ $patientCount }}</li>
                    <li class="text-purple-500">Dentistry Student: {{ $dentistrystudentCount }}</li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Total Patients</h2>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $patientCount }}</p>
                <div class="mt-4">
                    <p class="text-gray-500">Keep track of registered patients in the system.</p>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Total Dentistry Students</h2>
                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $dentistrystudentCount }}</p>
                <div class="mt-4">
                    <p class="text-gray-500">Keep track of registered dentistry students in the system.</p>
                </div>
            </div>
        </div>

        
    </div>

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
                                <td class="border-b px-6 py-4">
                                    <button class="editItemButton bg-yellow-500 text-white px-4 py-2 rounded transition duration-200 hover:bg-yellow-600" data-id="{{ $inventory->id }}" data-item_name="{{ $inventory->item_name }}" data-quantity="{{ $inventory->quantity }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('inventory.destroy', $inventory) }}" method="POST" class="inline" onsubmit="return confirmDelete();">
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
                <div class="mt-2">
                    <label for="quantity" class="block">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="w-full rounded-lg focus:ring-2 shadow-sm" required>
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
                document.getElementById('quantity').value = quantity;
            });
        });

        closeModalButton.addEventListener('click', () => {
            inventoryModal.classList.add('hidden');
        });

        function confirmDelete() {
            return confirm("Are you sure you want to delete this item? This action cannot be undone.");
        }
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
                // Optional: Automatically close the popup after a few seconds
                setTimeout(closePopup, 5000); // Close after 5 seconds
            });
        </script>
    @endif

@section('title')
    Dashboard
@endsection

</x-app-layout>
