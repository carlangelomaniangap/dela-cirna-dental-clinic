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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-money-bills"></i> Payment Info</h4>
    </div>

    <div class="px-6 py-4 flex justify-between items-center">
        <a href="{{ route('admin.payment.create') }}" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300 text-xs sm:text-sm lg:text-base font-semibold"><i class="fa-solid fa-cash-register"></i> New</a>

        <form action="{{ route('admin.paymentinfo.search') }}" method="GET">
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
            @if($paymentinfo->isEmpty())
                <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition duration-200">
                    <p class="px-4 sm:px-6 py-3 text-gray-600">No payment info found.</p>
                </div>
            @else
                @foreach ($paymentinfo as $payment)
                    <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition duration-200">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm sm:text-base lg:text-lg font-semibold text-gray-800">{{ $payment->name }}</p>
                                <ul class="text-sm sm:text-base text-gray-600 list-disc pl-5">
                                    <li>
                                        <span class="font-semibold">Concern:</span> <span>{{ $payment->concern }}</span>
                                    </li>
                                    <li>
                                        <span class="font-semibold">Amount:</span> <span>{{ $payment->amount > 0 ? number_format($payment->amount, 0, ',', ',') : 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <span class="font-semibold">Balance:</span> <span>{{ $payment->balance == 0 ? 'Paid' : number_format($payment->balance, 0, ',', ',') }}</span>
                                    </li>
                                    <li>
                                        <span class="font-semibold">Date:</span> <span>{{ date('F j, Y', strtotime($payment->date)) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="relative inline-block text-left">
                                <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none dropdown-button" aria-haspopup="true" aria-expanded="false" data-dropdown-id="dropdown-{{ $payment->id }}">
                                    <span class="text-gray-600"><i class="fa-solid fa-ellipsis"></i></span>
                                </button>

                                <div class="absolute right-0 z-10 mt-2 w-32 lg:w-48 px-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden dropdown-menu" id="dropdown-{{ $payment->id }}" role="menu" aria-orientation="vertical">
                                    <div class="py-1" role="none">
                                       <!-- Button to Open Modal -->
                                        <button data-payment-id="{{ $payment->id }}" class="block w-full text-left px-4 py-2 text-sm sm:text-base text-blue-700 hover:bg-blue-100 hover:rounded-lg"><i class="fa fa-solid fa-plus"></i> Payment</button>
                                        <a href="{{ route('admin.paymentHistory', $payment->id) }}" class="block px-4 py-2 text-sm sm:text-base text-gray-700 hover:bg-gray-100 hover:rounded-lg"><i class="fas fa-history"></i> History</a>
                                        <a href="{{ route('admin.updatePayment', $payment->id) }}" class="block px-4 py-2 text-sm sm:text-base text-blue-700 hover:bg-blue-100 hover:rounded-lg">
                                            <i class="fa-solid fa-pen update"></i> Edit
                                        </a>
                                        <div class="h-px bg-gray-300 my-1"></div>
                                        <form method="post" action="{{ route('admin.deletePayment', $payment->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm sm:text-base text-red-700 hover:bg-red-100 hover:rounded-lg" onclick="return confirm('Are you sure you want to delete this payment info?')"><i class="fa-regular fa-trash-can"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Modal Background -->
        <div id="paymentModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 shadow-lg">
            <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-5">
            <h4 class="text-lg font-bold">Make a Payment</h4>
                </div>
                <form method="POST" id="paymentForm">
                    @csrf

                    <div class="mb-4">
                        <label for="payment" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                        <input type="number" id="payment" name="payment" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white transition duration-300 rounded">Submit</button>
                        <button type="button" id="closeModal" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4">
            {{ $paymentinfo->links() }}
        </div>
    </div>
    
    <script> // modals
        const closeModal = document.getElementById('closeModal');
        const paymentModal = document.getElementById('paymentModal');
        const paymentInput = paymentModal.querySelector('#payment');
        // Select all buttons with data-payment-id
        const openModalButtons = document.querySelectorAll('[data-payment-id]');

        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const paymentId = button.getAttribute('data-payment-id'); // Get the payment ID
                const form = document.getElementById('paymentForm'); // Get the form inside the modal
                form.action = `/admin/paymentinfo/addpayment/${paymentId}`; // Set the form action
                paymentModal.classList.remove('hidden'); // Show the modal
            });
        });

        closeModal.addEventListener('click', () => {
            paymentInput.value = '';
            paymentModal.classList.add('hidden');
        });
    </script>

    <script> // buttons dropdown
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButtons = document.querySelectorAll('.dropdown-button');
            const dropdownHeight = 195; // Set your fixed dropdown height here

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
    </script>
    
</body>
</html>

@section('title')
    Payment Info
@endsection

</x-app-layout>
