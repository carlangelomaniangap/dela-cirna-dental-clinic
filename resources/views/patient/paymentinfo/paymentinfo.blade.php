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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-money-bills"></i> Payment Information</h4>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if($paymentinfo->isEmpty())
                <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition duration-200">
                    <p class="px-4 sm:px-6 py-3 text-gray-600">No payment info found.</p>
                </div>
            @else
                @foreach ($paymentinfo as $payment)
                    <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition duration-200">
                        <div class="flex flex-col">
                            <div class="flex justify-between items-start">
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
                                <div class="sm:flex sm:items-start hidden">
                                    <a href="{{ route('patient.paymentHistory', $payment->id) }}" class="px-2 sm:px-4 py-2 text-white text-sm sm:text-base bg-blue-600 hover:bg-blue-800 transition duration-300 rounded"><i class="fas fa-history"></i> History</a>
                                </div>
                            </div>
                            <div class="flex justify-end mt-2 sm:hidden">
                                <a href="{{ route('patient.paymentHistory', $payment->id) }}" class="px-2 sm:px-4 py-2 text-white text-sm sm:text-base bg-blue-600 hover:bg-blue-800 transition duration-300 rounded">
                                    <i class="fas fa-history"></i> History
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    
</body>
</html>

@section('title')
    Payment Info
@endsection

</x-app-layout>
