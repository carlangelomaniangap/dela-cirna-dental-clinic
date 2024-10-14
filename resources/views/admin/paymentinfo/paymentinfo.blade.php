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

        @if ($paymentinfo->lastPage() > 1)
            <ul class="pagination mt-8 mb-8 flex items-center justify-center">
                @if ($paymentinfo->onFirstPage())
                    <li class="page-item disabled mx-1" aria-disabled="true">
                        <span class="page-link text-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" aria-hidden="true">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link text-blue-500 hover:text-white hover:bg-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" href="{{ $paymentinfo->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                    </li>
                @endif

                @for ($i = 1; $i <= $paymentinfo->lastPage(); $i++)
                    @if ($i == $paymentinfo->currentPage())
                        <li class="page-item active mx-1" aria-current="page">
                            <span class="page-link text-white px-4 py-2 rounded-lg bg-blue-500">{{ $i }}</span>
                        </li>
                    @else
                        <li class="page-item mx-1">
                            <a class="page-link text-blue-500 hover:text-white hover:bg-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" href="{{ $paymentinfo->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                @if ($paymentinfo->hasMorePages())
                    <li class="page-item mx-1">
                        <a class="page-link text-blue-500 hover:text-white hover:bg-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" href="{{ $paymentinfo->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link text-blue-500 px-4 py-2 rounded-lg bg-white border border-gray-300" aria-hidden="true">&raquo;</span>
                    </li>
                @endif
            </ul>
        @endif
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
