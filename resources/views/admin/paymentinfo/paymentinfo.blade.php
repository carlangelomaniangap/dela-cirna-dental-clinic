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

    <div class="relative overflow-x-auto">
            <table class="min-w-full bg-white text-left rtl:text-right">
                <thead class="text-gray-800">
                    <tr class="border-b-2">
                        <th scope="col" class="px-6 py-4">Patient Name</th>
                        <th scope="col" class="px-6 py-4">Description</th>
                        <th scope="col" class="px-6 py-4">Amount</th>
                        <th scope="col" class="px-6 py-4">Balance</th>
                        <th scope="col" class="px-6 py-4">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentinfo as $payment)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $payment->patientname }}</td>
                            <td class="px-6 py-4">{{ $payment->description }}</td>
                            <td class="px-6 py-4"><i class="fa-solid fa-peso-sign"></i>{{ $payment->amount }}</td>
                            <td class="px-6 py-4"><i class="fa-solid fa-peso-sign"></i>{{ $payment->balance }}</td>
                            <td class="px-6 py-4">{{ $payment->date }}</td>
                            <td class="px-6 py-4">
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
                </tbody>
            </table>

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
    
</body>
</html>

@section('title')
    Payment Info
@endsection

</x-app-layout>
