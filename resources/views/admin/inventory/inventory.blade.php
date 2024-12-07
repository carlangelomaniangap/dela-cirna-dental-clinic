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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold">{{ __('Inventory') }}</h4>
    </div> -->

    @if(session('success') || $errors->any() || session('error'))
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="relative p-4 w-full max-w-md">
                <div class="relative p-5 text-center bg-white rounded-lg shadow">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center" onclick="this.closest('.fixed').style.display='none'">
                        <i class="fa-solid fa-xmark text-lg"></i>
                        <span class="sr-only">Close modal</span>
                    </button>

                    @if(session('success'))
                        <!-- Success icon and message -->
                        <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-check text-green-500 text-2xl"></i>
                            <span class="sr-only">Success</span>
                        </div>
                        <p class="mb-4 text-lg font-semibold text-gray-900">{{ session('success') }}</p>
                    @elseif(session('error'))
                        <!-- Error icon and message -->
                        <div class="w-12 h-12 rounded-full bg-red-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-xmark text-red-500 text-2xl"></i>
                            <span class="sr-only">Error</span>
                        </div>
                        <p class="mb-4 text-lg font-semibold text-red-600">{{ session('error') }}</p>
                    @elseif($errors->any())
                        <!-- Validation errors -->
                        <div class="w-12 h-12 rounded-full bg-red-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-xmark text-red-500 text-2xl"></i>
                            <span class="sr-only">Error</span>
                        </div>
                        @foreach ($errors->all() as $error)
                            <p class="mb-4 text-lg font-semibold text-red-600">{{ $error }}</p>
                        @endforeach
                    @endif

                    <!-- Continue button -->
                    <button type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300" onclick="this.closest('.fixed').style.display='none'">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="p-6">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <!-- Button to Open Add New Item Modal -->
            <div class="p-6">
                <div class="flex flex-col sm:flex-row items-center justify-between mb-4">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Inventory</h1>
                    <button type="button" id="AddOpenModalBtn" class="mt-2 sm:mt-0 bg-blue-600 hover:bg-blue-700 text-white transition duration-300 px-4 py-2 rounded max-w-xs font-semibold">Add Item</button>
                </div>
            </div>

            <!-- Modal for Adding New Item -->
            <div id="AddItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
            
                <div class="bg-white p-4 rounded-lg shadow-md z-10">
                    <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-5">
                        <h4 class="text-lg font-bold">Add Item</h4>
                    </div>
                    <form id="AddItemForm" action="{{ route('admin.inventory.store') }}" method="POST">
                        @csrf

                        <!-- Item Name -->
                        <div class="mb-4">
                            <label for="item_name" class="block text-sm font-medium text-gray-900 dark:text-white">Item Name</label>
                            <input type="text" name="item_name" id="item_name" class="mt-2 block w-full px-4 py-2 border rounded-md" required>
                        </div>

                        <!-- Item Type Selection -->
                        <div class="mb-4">
                            <label for="item_type" class="block text-sm font-medium text-gray-900 dark:text-white">Item Type</label>
                            <select name="item_type" id="item_type" class="mt-2 block w-full px-4 py-2 border rounded-md" required onchange="toggleFields()">
                                <option value="" selected disabled>Select Item Type</option>
                                <option value="Equipment">Equipment</option>
                                <option value="Consumable">Consumable</option>
                            </select>
                        </div>

                        <!-- Total Quantity (Initially hidden) -->
                        <div class="mb-4 hidden" id="total_quantity_container">
                            <label for="total_quantity" class="block text-sm font-medium text-gray-900 dark:text-white">Total Quantity</label>
                            <input type="number" name="total_quantity" id="total_quantity" class="mt-2 block w-full px-4 py-2 border rounded-md" required>
                        </div>

                        <!-- Expiration Date (Initially hidden) -->
                        <div class="mb-4 hidden" id="expiration_date_container">
                            <label for="expiration_date" class="block text-sm font-medium text-gray-900 dark:text-white">Expiration Date</label>
                            <input type="date" name="expiration_date" id="expiration_date" class="mt-2 block w-full px-4 py-2 border rounded-md" required>
                        </div>

                        <div class="mt-4 text-right">
                            <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300" id="modalSubmitBtn">Add</button>
                            <button type="button" id="AddCloseModalBtn" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Inventory List -->
            <div class="mt-4">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Item Name</th>
                            <th class="px-4 py-2 border">Item Type</th>
                            <th class="px-4 py-2 border">Total Quantity</th>
                            <th class="px-4 py-2 border">Available Quantity</th>
                            <th class="px-4 py-2 border">Expiration Date</th>
                            <th class="px-4 py-2 border">Quantity Used</th>
                            <th class="px-4 py-2 border">Last Updated</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td class="px-4 py-2 border">{{ $item->item_name }}</td>
                            <td class="px-4 py-2 border">{{ $item->item_type }}</td>
                            <td class="px-4 py-2 border">{{ $item->total_quantity }}</td>
                            <td class="px-4 py-2 border">{{ $item->available_quantity }}</td>
                            <td class="px-4 py-2 border">{{ $item->expiration_date ? date('F j, Y', strtotime($item->expiration_date)) : 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ $item->quantity_used }}</td>
                            <td class="px-4 py-2 border">{{ $item->updated_at ? date('F j, Y', strtotime($item->updated_at)) : 'N/A' }}</td>
                            <td class="px-4 py-2 border">
                                <button type="button" data-item-id="{{ $item->id }}" data-item-type="{{ $item->item_type }}" class="mt-2 sm:mt-0 bg-blue-600 hover:bg-blue-700 text-white transition duration-300 px-4 py-2 rounded max-w-xs font-semibold">Update Item</button>
                            </td>
                        </tr>

                        <!-- Modal for Updating New Item -->
                        <div id="UpdateItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                        
                            <div class="bg-white p-4 rounded-lg shadow-md z-10">
                                <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-5">
                                    <h4 class="text-lg font-bold">Update Item</h4>
                                </div>
                                <form id="UpdateItemForm" action="{{ route('admin.inventory.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Item Type Selection -->
                                    <div class="mb-4 hidden" id="action_container">
                                        <label for="action" class="block text-sm font-medium text-gray-900 dark:text-white">Action</label>
                                        <select name="action" id="action" class="mt-2 block w-full px-4 py-2 border rounded-md" required>
                                            <option value="" selected disabled>Select Action</option>
                                            <option value="add">Add</option>
                                            <option value="used">Used</option>
                                        </select>
                                    </div>

                                    <!-- Quantity (Initially hidden) -->
                                    <div class="mb-4" id="quantity_container">
                                        <label for="quantity" class="block text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="mt-2 block w-full px-4 py-2 border rounded-md" required>
                                    </div>

                                    <div class="mt-4 text-right">
                                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300" id="modalSubmitBtn">Add</button>
                                        <button type="button" id="UpdateCloseModalBtn" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // ADD ITEM
        // Show the modal when the button is clicked
        document.getElementById("AddOpenModalBtn").addEventListener("click", function() {
            const modal = document.getElementById("AddItemModal");
            modal.classList.remove("hidden");
        });

        // Close modal
        document.getElementById("AddCloseModalBtn").addEventListener("click", function() {
            document.getElementById("AddItemModal").classList.add("hidden");
        });

        // Toggle fields based on item type selection
        function toggleFields() {
            const itemType = document.getElementById("item_type").value;
            const totalQuantityContainer = document.getElementById("total_quantity_container");
            const expirationDateContainer = document.getElementById("expiration_date_container");
            const expirationDateInput = document.getElementById("expiration_date");

            if (itemType === "Equipment") {
                totalQuantityContainer.classList.remove("hidden");
                expirationDateContainer.classList.add("hidden");
                expirationDateInput.removeAttribute("required");
            } else if (itemType === "Consumable") {
                totalQuantityContainer.classList.remove("hidden");
                expirationDateContainer.classList.remove("hidden");
                expirationDateInput.setAttribute("required", "true");
            } else  {
                totalQuantityContainer.classList.add("hidden");
                expirationDateContainer.classList.add("hidden");
            }
        }
    </script>

    <script>
        // UPDATE ITEM
        // Open the modal when any button is clicked
        document.querySelectorAll('[data-item-id]').forEach(function(button) {
            button.addEventListener("click", function() {
                // Get the item ID from the clicked button's data-item-id
                const itemId = this.getAttribute("data-item-id");
                const itemType = this.getAttribute("data-item-type");
                
                // Show the modal
                const modal = document.getElementById("UpdateItemModal");
                modal.classList.remove("hidden");

                // Dynamically update the form action URL with the correct item ID
                const form = document.getElementById("UpdateItemForm");
                form.action = `/admin/inventory/${itemId}/update`; // Update the form action dynamically for this specific item

                // Get the item type from the form (or from a hidden field)
                const actioncontainer = document.getElementById("action_container");
                const actionInput = document.getElementById("action");

                if (itemType === "Equipment") {
                    actioncontainer.classList.add("hidden");
                    actionInput.removeAttribute("required");
                } else if (itemType === "Consumable") {
                    actioncontainer.classList.remove("hidden");
                    actionInput.setAttribute("required", "true");
                }
            });
        });

        // Close the modal when the cancel button is clicked
        document.getElementById("UpdateCloseModalBtn").addEventListener("click", function() {
            const modal = document.getElementById("UpdateItemModal");
            modal.classList.add("hidden");  // Hide the modal
        });
    </script>
    
</body>
</html>

@section('title')
    Inventory
@endsection

</x-app-layout>