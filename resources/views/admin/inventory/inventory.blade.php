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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold">{{ __('Inventory') }}</h4>
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
        <div class="bg-white shadow-lg rounded-lg p-4 sm:p-6 mb-6">

            <div class="flex flex-col sm:flex-row items-center justify-between mb-4">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Inventory</h1>
                <button id="createInventoryButton" class="mt-2 sm:mt-0 bg-blue-600 hover:bg-blue-700 text-white transition duration-300 px-4 py-2 rounded max-w-xs font-semibold">Add Item</button>
            </div>

            <div class="">
                <table id="inventoryTable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($inventories->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">No items found.</td>
                            </tr>
                        @else
                            @foreach ($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->item_name }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>
                                        <div class="relative inline-block text-left">
                                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none dropdown-button" aria-haspopup="true" aria-expanded="false" data-dropdown-id="dropdown-{{ $inventory->id }}">
                                                <span class="text-gray-600"><i class="fa-solid fa-ellipsis"></i></span>
                                            </button>

                                            <div class="absolute right-0 z-10 mt-2 w-28 lg:w-48 px-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden dropdown-menu" id="dropdown-{{ $inventory->id }}" role="menu" aria-orientation="vertical">
                                                <div class="py-1" role="none">
                                                    <a href="{{ route('admin.inventory.show', $inventory->id) }}" class="block px-4 py-2 text-sm sm:text-base text-gray-700 hover:bg-gray-100 hover:rounded-lg" role="menuitem"><i class="fas fa-history"></i> History</a>
                                                    <button class="editItemButton block w-full text-left px-4 py-2 text-sm sm:text-base text-blue-700 hover:bg-blue-100 hover:rounded-lg" data-id="{{ $inventory->id }}" data-item_name="{{ $inventory->item_name }}" data-quantity="{{ $inventory->quantity }}" role="menuitem"><i class="fa-solid fa-pen"></i> Edit</button>
                                                    <div class="h-px bg-gray-300 my-1"></div>
                                                    <form method="post" action="{{ route('admin.inventory.destroy', $inventory->id) }}">
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

<!-- Include jQuery and DataTables CSS/JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable({
            "paging": true,          // Enable pagination
            "lengthChange": true,    // Allow changing number of rows per page
            "searching": true,       // Enable search box
            "ordering": true,        // Enable column sorting
            "info": true,            // Display table information
            "autoWidth": false,      // Auto adjust column widths
            "responsive": true,      // Make the table responsive on smaller screens
            "language": {
                "search": "Search:",      // Customize search box placeholder text
                "lengthMenu": "Show _MENU_ entries", // Customize "Show entries" text
                "paginate": {
                    "first": "«",    // First page button text
                    "previous": "‹", // Previous page button text
                    "next": "›",     // Next page button text
                    "last": "»"      // Last page button text
                },
                "zeroRecords": "No items found",   // Custom text when no records match search
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"  // Info text for pagination
            }
        });
    });
</script>


    <!-- Modal for Create/Edit Item -->
    <div id="inventoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
        
        <div class="bg-white p-4 rounded-lg shadow-md z-10">
            <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-5">
                <h4 class="text-lg font-bold" id="modalTitle">Add Item</h4>
            </div>
            <form id="inventoryForm" action="{{ route('admin.inventory.store') }}" method="POST">
                    
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
            inventoryForm.action = "{{ route('admin.inventory.store') }}";
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
    
</body>
</html>

@section('title')
    Inventory
@endsection

</x-app-layout>