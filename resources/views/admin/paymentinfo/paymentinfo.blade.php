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
        <h4><i class="fa-solid fa-money-bills"></i> Payment Info</h4>
    </div>

    <div class="actions px-6 py-4 flex justify-between items-center">
        <a href="{{ route('admin.payment.create') }}" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white">
            <i class="fa-solid fa-cash-register"></i> New
        </a>

        <form action="{{ route('admin.paymentinfo.search') }}" method="GET">
            <div class="relative w-full">
                <input type="text" name="query" placeholder="Search" class="w-full h-10 px-3 rounded-full focus:ring-2 border border-gray-300 focus:outline-none focus:border-blue-500" />
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
                    <th class="px-6 py-4">Concern</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Balance</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($paymentinfo->isEmpty())
                    <tr>
                        <td class="px-6 py-4 text-gray-600">No payment info found.</td>
                    </tr>
                @else
                    @foreach ($paymentinfo as $payment)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $payment->name }}</td>
                            <td class="px-6 py-4">{{ $payment->concern }}</td>
                            <td class="px-6 py-4">{{ $payment->amount > 0 ? number_format($payment->amount, 0, ',', ',') : '' }}</td>
                            <td class="px-6 py-4">{{ $payment->balance == 0 ? 'Paid' : number_format($payment->balance, 0, ',', ',') }}</td>
                            <td class="px-6 py-4">{{ date('F j, Y', strtotime($payment->date)) }}</td>
                            <td class="px-6 py-4">
                                <!-- Button to Open Modal -->
                                <a data-payment-id="{{ $payment->id }}" class="px-4 py-2 text-white bg-blue-600 rounded cursor-pointer">Add Payment</a>
                                <a href="{{ route('admin.paymentHistory', $payment->id) }}" class="px-4 py-2 text-white bg-blue-600 rounded cursor-pointer">History</a>
                                <a href="{{ route('admin.updatePayment', $payment->id) }}" class="px-4 py-2 rounded text-gray-800 hover:bg-gray-200 transition duration-300 text-base">
                                    <i class="fa-solid fa-pen update"></i> Edit
                                </a>
                                <a href="{{ route('admin.deletePayment', $payment->id) }}" class="px-4 py-2 rounded text-red-800 hover:bg-red-200 transition duration-300 text-base" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this record?')) { document.getElementById('delete-payment-form-{{ $payment->id }}').submit(); }">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </a>
                                <form id="delete-payment-form-{{ $payment->id }}" method="post" action="{{ route('admin.deletePayment', $payment->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Modal Background -->
        <div id="paymentModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 shadow-lg w-1/3">
                <div class="bg-[#4b9cd3;] rounded-lg py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-10">
                    <h4>Make a Payment</h4>
                </div>
                <form method="POST" id="paymentForm">
                    @csrf

                    <div class="mb-4">
                        <label for="payment" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                        <input type="number" id="payment" name="payment" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Submit</button>
                        <button type="button" id="closeModal" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4">
            {{ $paymentinfo->links() }}
        </div>
    </div>
    
    <script>
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
    
</body>
</html>

@section('title')
    Payment Info
@endsection

</x-app-layout>
