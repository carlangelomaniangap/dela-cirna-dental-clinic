<x-app-layout>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
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
            <div class="p-6 pb-0 print:hidden">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Inventory</h1>
                    <button type="button" id="AddOpenModalBtn" class="bg-blue-600 hover:bg-blue-700 text-white transition duration-300 px-4 py-2 rounded font-semibold">Add Item</button>
                </div>
            </div>

            <!-- Modal for Adding New Item -->
            <div id="AddItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-50 relative">
                    <button type="button" id="AddCloseModalBtn" class="mr-2 absolute top-0 right-0 text-lg text-gray-400 hover:text-gray-700"><i class="fa-solid fa-xmark text-xl"></i></button>
                        
                    <div class="mb-4">
                        <h1 class="text-lg font-bold">ADD ITEM</h1>
                    </div>
                        
                    <form id="AddItemForm" action="{{ route('admin.inventory.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div>
                                <label for="item_name" class="block text-sm font-semibold text-gray-700">Item Name</label>
                                <input type="text" name="item_name" id="item_name" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700">Type</label>
                                <select name="type" id="type" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required onchange="toggleFields()">
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="Consumable">Consumable</option>
                                </select>
                            </div>

                            <div>
                                <label for="unit" class="block text-sm font-semibold text-gray-700">Unit</label>
                                <select name="unit" id="unit" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="" selected disabled>Select Unit</option>
                                    <option value="Each">Each</option>
                                    <option value="Box">Box</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Tube">Tube</option>
                                    <option value="Bottle">Bottle</option>
                                    <option value="Bag">Carton</option>
                                    <option value="Kit">Packet</option>
                                    <option value="Set">Set</option>
                                </select>
                            </div>

                            <div>
                                <label for="stocks" class="block text-sm font-semibold text-gray-700">Stocks Quantity</label>
                                <input type="number" name="stocks" id="stocks" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="has_expiration_date" class="mr-2" onchange="toggleExpirationDate()">
                                <label for="has_expiration_date" class="text-sm font-semibold text-gray-700">Has Expiration Date</label>
                            </div>

                            <div class="hidden" id="expiration_date_container">
                                <label for="expiration_date" class="block text-sm font-semibold text-gray-700">Expiration Date</label>
                                <input type="date" name="expiration_date" id="expiration_date" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                        </div>

                        <div class="mt-6 text-right">
                            <button type="submit" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300" id="modalSubmitBtn">Add</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Inventory List -->
            <div class="p-6">
                <table id="inventory-content" class="hover min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Type</th>
                            <th>Unit</th>
                            <th>Stocks</th>
                            <th>Issuance</th>
                            <th>Disposed</th>
                            <th>Remaining Stocks</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>
                                    <a href="{{ route('admin.addstock_history', $item->id) }}" class="hover:text-gray-400">{{ number_format($item->stocks) }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.issuance_history', $item->id) }}" class="hover:text-gray-400">{{ number_format($item->issuance) }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.dispose_history', $item->id) }}" class="hover:text-gray-400">{{ number_format($item->disposed) }}</a>
                                </td>
                                <td>{{ number_format($item->remaining_stocks) }}</td>
                                <td class="action">
                                    <button type="button" data-item-id="{{ $item->id }}" data-item-name="{{ $item->item_name }}" data-item-unit="{{ $item->unit }}" class="bg-blue-600 hover:bg-blue-700 text-white transition duration-300 px-2 py-1 rounded"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" data-item-id="{{ $item->id }}" class="AddStockOpenModalBtn px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300"><i class="fa-solid fa-circle-plus"></i></button>
                                    <button type="button" data-item-id="{{ $item->id }}" class="IssuanceOpenModalBtn px-2 py-1 bg-yellow-500 text-white rounded hover:bg-green-600 transition duration-300"><i class="fa-solid fa-user-pen"></i></button>
                                    <button type="button" value="{{ $item->id }}" data-item-type="{{ $item->type }}" data-modal-target="dispose-modal" data-modal-toggle="dispose-modal"
                                    data-stocks-details="{{ $stocks->map(fn($stock) => 
                                    [ 'id' => $stock->id, 
                                    'inve_id' => $stock->inventory_id, 
                                    'quantity' => $stock->quantity, 
                                    'expiration_date' => $stock->expiration_date ])->toJson() }}" 
                                    class="DisposeOpenModalBtn px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300"><i class="fa-solid fa-trash"></i></button>
                                </td>
                             </tr>

                             <!-- Modal for Update Item -->
                            <div id="UpdateItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                                    <button type="button" id="UpdateCloseModalBtn" class="mr-2 absolute top-0 right-0 text-lg text-gray-400 hover:text-gray-700"><i class="fa-solid fa-xmark text-xl"></i></button>
                                        
                                    <div class="mb-4">
                                        <h1 class="text-lg font-bold">UPDATE</h1>
                                    </div>

                                    <form id="UpdateItemForm" action="{{ route('admin.inventory.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-4">
                                            <label for="item_name" class="block text-sm font-semibold text-gray-700">Item Name</label>
                                            <input type="text" name="item_name" id="item_name" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $item->item_name }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="unit" class="block text-sm font-semibold text-gray-700">Unit</label>
                                            <select name="unit" id="unit" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="Each" {{ $item->unit == 'Each' ? 'selected' : '' }}>Each</option>
                                                <option value="Box" {{ $item->unit == 'Box' ? 'selected' : '' }}>Box</option>
                                                <option value="Pack" {{ $item->unit == 'Pack' ? 'selected' : '' }}>Pack</option>
                                                <option value="Tube" {{ $item->unit == 'Tube' ? 'selected' : '' }}>Tube</option>
                                                <option value="Bottle" {{ $item->unit == 'Bottle' ? 'selected' : '' }}>Bottle</option>
                                                <option value="Bag" {{ $item->unit == 'Bag' ? 'selected' : '' }}>Bag</option>
                                                <option value="Kit" {{ $item->unit == 'Kit' ? 'selected' : '' }}>Kit</option>
                                                <option value="Set" {{ $item->unit == 'Set' ? 'selected' : '' }}>Set</option>
                                            </select>
                                        </div>

                                        <div class="mt-4 text-right">
                                            <button type="submit" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal for Add Stock -->
                            <div id="AddStockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                                    <button type="button" id="AddStockCloseModalBtn" class="mr-2 absolute top-0 right-0 text-lg text-gray-400 hover:text-gray-700"><i class="fa-solid fa-xmark text-xl"></i></button>
                                        
                                    <div class="mb-4">
                                        <h1 class="text-lg font-bold">ADD STOCKS</h1>
                                    </div>

                                    <form id="addStockForm" action="{{ route('admin.inventory.AddStock', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-4">
                                            <label for="receiver_name" class="block text-sm font-semibold text-gray-700">Receiver Name</label>
                                            <input type="text" name="receiver_name" id="receiver_name" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="expiration_date" class="block text-sm font-semibold text-gray-700">Expiration Date</label>
                                            <input type="date" name="expiration_date" id="expiration_date" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div class="mb-4">
                                            <label for="quantity" class="block text-sm font-semibold text-gray-700">Quantity</label>
                                            <input type="number" name="quantity" id="quantity" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>

                                        <button type="submit" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300">Add new stock</button>

                                        <div class="mt-4 text-right">
                                            <button type="submit" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300">Restock</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal for Issuance -->
                            <div id="IssuanceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                                    <button type="button" id="IssuanceCloseModalBtn" class="mr-2 absolute top-0 right-0 text-lg text-gray-400 hover:text-gray-700"><i class="fa-solid fa-xmark text-xl"></i></button>
                                        
                                    <div class="mb-4">
                                        <h1 class="text-lg font-bold">Assign</h1>
                                    </div>

                                    <form id="IssuanceForm" action="{{ route('admin.inventory.issuance', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-4">
                                            <label for="total_quantity" class="block text-sm font-semibold text-gray-700">Total Stocks</label>
                                            <input type="number" name="total_quantity" id="total_quantity" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100" value="{{ $stocks->first()->quantity }}" readonly>
                                        </div>

                                        <div class="mb-4">
                                            <label for="remaining_stocks" class="block text-sm font-semibold text-gray-700">Remaining Stocks</label>
                                            <input type="number" name="remaining_stocks" id="remaining_stocks" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100" readonly>
                                        </div>

                                        <div class="mb-4">
                                            <label for="users_id" class="block text-sm font-semibold text-gray-700">Distribute to</label>
                                            <select class="block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" id="users_id" name="users_id" required>
                                                <option value="" disabled selected>Distribute</option>
                                                @foreach($patients  as $patient )
                                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="issuance" class="block text-sm font-semibold text-gray-700">Issuance</label>
                                            <input type="number" name="issuance" id="issuance" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500" required>
                                            <div id="issuanceError" class="text-sm text-red-500 mt-1 hidden">
                                                Issuance exceeds the available stock!
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="stocks" class="block text-sm font-semibold text-gray-700">Stocks</label>
                                            <div id="stocks" name="stocks">
                                                @if($stocks->isNotEmpty())
                                                    <div value="{{ $stocks->first()->id }}">
                                                        <p>Quantity: {{ $stocks->first()->quantity }}</p>
                                                        <p>Expires: {{ $stocks->first()->expiration_date ? date('F j, Y', strtotime($stocks->first()->expiration_date)) : 'N/A' }}</p>
                                                    </div>
                                                @else
                                                    <div>No stock available</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-4 text-right">
                                            <button type="submit" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300">Assign</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal for Dispose -->
                            <div id="dispose-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                                    <button type="button" data-modal-hide="dispose-modal" class="mr-2 absolute top-0 right-0 text-lg text-gray-400 hover:text-gray-700"><i class="fa-solid fa-xmark text-xl"></i></button>
                                        
                                    <div class="mb-4">
                                        <h1 class="text-lg font-bold">Dispose</h1>
                                    </div>

                                    <form action="{{ route('admin.inventory.dispose', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-4">
                                            <label for="reason" class="block text-sm font-semibold text-gray-700">Reason</label>
                                            <select class="block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" id="reason" name="reason" required>
                                                <option value="" disabled selected>Reason List</option>
                                                <option value="Expired">Expired</option>
                                                <option value="Damaged">Damaged</option>
                                                <option value="Single-Use">Single-Use</option>
                                                <option value="Used">Used</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-semibold text-gray-700">Stocks</label>
                                            <select name="stock_id" id="stocks_container" class="block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>

                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="disposequantity" class="block text-sm font-semibold text-gray-700">Quantity</label>
                                            <input type="number" name="disposequantity" id="disposequantity" class="mt-2 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                            <div id="quantityError" class="text-sm text-red-500 mt-1 hidden">
                                                Quantity exceeds the available stock!
                                            </div>
                                        </div>

                                        <div class="mt-4 text-right">
                                            <input type="number" hidden id="dispose-item-id" name="item_id">
                                            <button type="submit" id="dispose-submit" class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white transition duration-300">Dispose</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end mt-6">
                    <button onclick="openPrintView();" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-2 py-1.5 rounded transition duration-300">Print a copy</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- TABLE -->
    <script>
        $(document).ready(function() {
            new DataTable('#inventory-content', {
                "language": {
                    "emptyTable": "No items found.",
                    "zeroRecords": "No matching items found.",
                }
            });

            $('#inventory-content_length select').addClass('w-20');
            $('.dataTables_length').addClass('mb-4');
            $('.dataTables_filter').addClass('mb-4');
        });
    </script>

    <!-- STOCKS AND QUANTITY AND ISSUANCE PREVENT INPUT - and . -->
    <script>
        document.getElementById('stocks').addEventListener('keydown', function(event) {
            // Prevent entering minus '-' sign and period '.' (decimal point)
            if (event.key === '-' || event.key === '.' || event.key === 'e') {
                event.preventDefault();
            }
        });

        document.getElementById('quantity').addEventListener('keydown', function(event) {
            // Prevent entering minus '-' sign and period '.' (decimal point)
            if (event.key === '-' || event.key === '.' || event.key === 'e') {
                event.preventDefault();
            }
        });

        document.getElementById('issuance').addEventListener('keydown', function(event) {
            // Prevent entering minus '-' sign and period '.' (decimal point)
            if (event.key === '-' || event.key === '.' || event.key === 'e') {
                event.preventDefault();
            }
        });

        document.getElementById('disposequantity').addEventListener('keydown', function(event) {
            // Prevent entering minus '-' sign and period '.' (decimal point)
            if (event.key === '-' || event.key === '.' || event.key === 'e') {
                event.preventDefault();
            }
        });
    </script>

    <!-- ADD ITEM -->
    <script>
        // Show the modal when the button is clicked
        document.getElementById("AddOpenModalBtn").addEventListener("click", function() {
            const modal = document.getElementById("AddItemModal");
            modal.classList.remove("hidden");
        });

        // Close modal
        document.getElementById("AddCloseModalBtn").addEventListener("click", function() {
            document.getElementById("AddItemModal").classList.add("hidden");
        });

        // Toggle Expiration Date visibility based on checkbox
        function toggleExpirationDate() {
            const expirationDateField = document.getElementById('expiration_date_container');
            const hasExpirationDate = document.getElementById('has_expiration_date').checked;

            // Show expiration date if checkbox is checked, else hide it
            if (hasExpirationDate) {
                expirationDateField.classList.remove('hidden');
            } else {
                expirationDateField.classList.add('hidden');
            }
        }
    </script>

    <!-- UPDATE ITEM -->
    <script>
        // Open the modal when the button is clicked
        document.querySelectorAll('[data-item-id]').forEach(function(button) {
            button.addEventListener("click", function() {
                    
                const itemId = this.getAttribute('data-item-id');
                const itemName = this.getAttribute('data-item-name');
                const itemUnit = this.getAttribute('data-item-unit');

                const modal = document.getElementById("UpdateItemModal");

                modal.querySelector("#item_name").value = itemName;
                modal.querySelector("#unit").value = itemUnit;
                    
                const form = document.getElementById("UpdateItemForm");
                form.action = `/admin/inventory/${itemId}/update`;
                    
                modal.classList.remove("hidden");
            });
        });

        // Close the modal when the close button is clicked
        document.getElementById("UpdateCloseModalBtn").addEventListener("click", function() {
            const modal = document.getElementById("UpdateItemModal");
            modal.classList.add("hidden");
        });
    </script>

    <!-- ADD STOCK -->
    <script>
        // Open the "Add Stock" Modal
        document.querySelectorAll('.AddStockOpenModalBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                    
                const itemId = this.getAttribute('data-item-id');

                document.getElementById('UpdateItemModal').classList.add('hidden');

                const form = document.getElementById('addStockForm');
                form.action = `/admin/inventory/${itemId}/add-stock`;
                // Show the Add Stock modal
                document.getElementById('AddStockModal').classList.remove('hidden');
            });
        });

        // Close the "Add Stock" Modal
        document.getElementById('AddStockCloseModalBtn').addEventListener('click', function() {
            document.getElementById('AddStockModal').classList.add('hidden');
        });
    </script>

    <!-- ISSUANCE -->
    <script>
        document.querySelectorAll('.IssuanceOpenModalBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                
                const itemId = this.getAttribute('data-item-id');
                const itemRemainingStocks = this.getAttribute('data-item-remainingstocks');

                const form = document.getElementById('IssuanceForm');
                form.action = `/admin/inventory/${itemId}/issuance`;

                document.getElementById('UpdateItemModal')?.classList.add('hidden');

                document.getElementById('IssuanceModal').classList.remove('hidden');
            });
        });

        document.getElementById('IssuanceCloseModalBtn').addEventListener('click', function() {
            document.getElementById('IssuanceModal').classList.add('hidden');
        });

        document.addEventListener('DOMContentLoaded', function () {
            const issuanceInput = document.getElementById('issuance');
            const totalQuantityInput = document.getElementById('total_quantity');
            const remainingInput = document.getElementById('remaining_stocks');
            const issuanceError = document.getElementById('issuanceError');

            const totalQuantityValue = parseFloat(totalQuantityInput.value) || 0;

            issuanceInput.addEventListener('input', function () {
                const issuanceValue = parseFloat(issuanceInput.value) || 0;

                // Calculate the remaining stocks
                const totalQuantity = parseFloat(totalQuantityInput.value) || 0;
                const remainingStocks = totalQuantity - issuanceValue;

                // Set the remaining value dynamically
                remainingInput.value = remainingStocks >= 0 ? remainingStocks : 0; // Ensure remaining stock can't be negative

                // Check if issuance exceeds total stocks
                if (issuanceValue > totalQuantity) {
                    // Show the error message
                    issuanceError.classList.remove('hidden'); // Show the error message
                    issuanceInput.classList.add('text-red-500', 'focus:ring-red-500');
                } else {
                    // Hide the error message
                    issuanceError.classList.add('hidden'); // Hide the error message
                    issuanceInput.classList.remove('text-red-500', 'focus:ring-red-500');
                }

                // If the issuance input is empty (value removed), reset the remaining input to total stocks value
                if (issuanceValue === 0) {
                    remainingInput.value = '';
                    issuanceError.classList.add('hidden');
                    issuanceInput.classList.remove('border-red-500', 'focus:ring-red-500');
                }
            });
        });
    </script>

    <!-- DISPOSE -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
        $(document).on('click', '.DisposeOpenModalBtn', function() {
                
                var item_id = $(this).val();
                $('#dispose-item-id').val(item_id);

                var stockDetails = $(this).data('stocks-details');                

                var stock_container = $('#stocks_container');
                stock_container.empty();
                stock_container.append('<option value="" disabled selected>Stocks</option>');

                if (Array.isArray(stockDetails)) {
                    stockDetails.forEach(function (stock) {
                        console.log(stock.inve_id);
                        
                        if (stock.quantity <= 0) {
                            return;
                        }
                        if (stock.inve_id == item_id) {
                            stock_container.append(`
                                <option value="${stock.id}" data-stock-quantity="${stock.quantity}"> 
                                    ${stock.expiration_date || 'N/A'} (${stock.quantity})
                                </option>
                        `);
                        }
                        
                    });
                } else {
                    console.error('stockDetails is not an array');
                }

                // $(document).on('keyup', '#disposequantity', function () {
                //     var quantity = parseFloat($('#stock_container').find('
                //     :selected').data('stock-quantity')) || 0;
                //     var disposequantity = parseFloat($(this).val()) || 0;

                //     if (disposequantity > quantity || quantity === 0) {
                //         $('#dispose-submit').prop('disabled', true)
                //         .removeClass('bg-orange-400')
                //         .addClass('bg-gray-400 cursor-not-allowed');
                //     } else {
                //         $('#dispose-submit').prop('disabled', false)
                //         .removeClass('bg-gray-400 cursor-not-allowed')
                //         .addClass('bg-orange-400');
                //     }
                // });
                
                // const itemId = this.getAttribute('data-item-id');

                // const form = document.getElementById('DisposeForm');
                // form.action = `/admin/inventory/${itemId}/dispose`;

                // document.getElementById('DisposeModal').classList.remove('hidden');
                
                // document.getElementById('UpdateItemModal')?.classList.add('hidden');
                // document.getElementById('AddStockModal')?.classList.add('hidden');
                // document.getElementById('IssuanceModal')?.classList.add('hidden');
        });

        // document.getElementById('DisposeCloseModalBtn').addEventListener('click', function() {
        //     document.getElementById('DisposeModal').classList.add('hidden');
        // });
    </script>

    <!-- PRINT -->
    <script>
        // Function to open the print view in a new tab
        function openPrintView() {
            var printWindow = window.open('', '_blank'); // Open a new tab
            printWindow.document.write('<html><head><title>Dela Cirna Dental Clinic</title>');

            // Add some basic styles for printing
            printWindow.document.write('<style>body { font-family: Arial, sans-serif; padding: 20px; }');
            printWindow.document.write('.print-content { width: 100%; border-collapse: collapse; margin-top: 20px; }');
            printWindow.document.write('.print-content th, .print-content td { border: 1px solid #ccc; padding: 10px; font-size: 14px; }');
            printWindow.document.write('.print-content th { background-color: #f4f4f4; }');
            printWindow.document.write('.no-print { display: block; }'); // Show the Print button
            printWindow.document.write('  .action { display: none !important; }'); // Hide update button column during print
            printWindow.document.write('{ pointer-events: none; opacity: 0.5; }'); // Disable content initially
            printWindow.document.write('@media print { .no-print { display: none; } }'); // Hide print button on print
            printWindow.document.write('</style>');

            // Add the content from the inventory page to the new tab
            var content = document.getElementById('inventory-content').innerHTML;

            // Replace anchor tags with normal text
            content = content.replace(/<a[^>]*href="[^"]*"[^>]*>/g, '<span>');  // Remove <a> tag opening
            content = content.replace(/<\/a>/g, '</span>'); // Remove <a> tag closing

            printWindow.document.write('<body>');
            printWindow.document.write('<h2>Inventory</h2>');
            printWindow.document.write('<table class="print-content inactive">' + content + '</table>'); // Disable content initially
            printWindow.document.write('<div class="no-print" style="margin-top: 20px;">');
            printWindow.document.write('<button onclick="enableContentAndPrint();" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; cursor: pointer; border: none;;">Print</button>');
            printWindow.document.write('</div>'); // Print button
            printWindow.document.write('</body></html>');

            // Function to enable content and open print dialog
            printWindow.document.write('<script>');
            printWindow.document.write('function enableContentAndPrint() {');
            printWindow.document.write('    var content = document.querySelector(".print-content");');
            printWindow.document.write('    content.classList.remove("inactive");'); // Enable content
            printWindow.document.write('    window.print();'); // Open the print dialog
            printWindow.document.write('}');
            printWindow.document.write('</' + 'script>');

            printWindow.document.close();
        }
    </script>

</body>
</html>

@section('title')
    Inventory
@endsection

</x-app-layout>