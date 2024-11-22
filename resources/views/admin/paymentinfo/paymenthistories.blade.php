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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-money-bills"></i> Payment Info / {{ $paymentInfo->name }}</h4>
    </div>
    <div class="p-6">    
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold mb-4">Payment History</h1>

            @if($paymenthistories->isEmpty())
                <div class="px-4 py-4 text-gray-600 text-center">No payment history found.</div>
            @else
                <div class="space-y-6">
                    @foreach ($paymenthistories as $history)
                        <div class="flex items-center border border-gray-200 rounded-lg p-4 bg-gray-50 shadow-sm hover:shadow-lg transition-shadow duration-300">
                            <div class="flex-shrink-0">
                                <i class="fas fa-credit-card text-xl lg:text-3xl text-gray-700"></i>
                            </div>
                            <div class="ml-4 flex-grow">
                                <div class="flex justify-between">
                                    <h2 class="font-semibold text-sm sm:text-base lg:text-lg text-gray-800">Amount: {{ number_format($history->payment, 0, ',', ',') }}</h2>
                                    <span class="{{ $history->status === 'Completed' ? 'text-green-600' : 'text-red-600' }} font-semibold">{{ $history->status }}</span>
                                </div>
                                <div class="text-gray-600 text-sm sm:text-base">
                                    <span class="font-semibold">Date:</span> {{ $history->created_at->setTimezone('Asia/Manila')->format('F j, Y') }} 
                                    | 
                                    <span class="font-semibold">Time:</span> {{ $history->created_at->setTimezone('Asia/Manila')->format('g:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</body>
</html>

@section('title')
    Payment History
@endsection

</x-app-layout>