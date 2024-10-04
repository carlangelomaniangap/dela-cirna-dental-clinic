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
        <h4><i class="fa-solid fa-money-bills"></i> Payment Info / {{ $paymentInfo->patientname }}</h4>
    </div>
    <div class="p-6">    
        <table class="min-w-full mt-4 bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-white text-gray-600 uppercase font-semibold text-sm text-left border-b-2">
                <tr>
                    <th class="px-6 py-4">Payment</th>
                    <th class="px-6 py-4">Time</th>
                    <th class="px-6 py-4">Date</th>
                </tr>
            </thead>
            <tbody>
                @if($paymenthistories->isEmpty())
                    <tr>
                        <td class="px-6 py-4 text-gray-600">No payment history found.</td>
                    </tr>
                @else
                    @foreach ($paymenthistories as $history)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ number_format($history->payment, 0, ',', ',') }}</td>
                            <td class="px-6 py-4">{{ $history->created_at->setTimezone('Asia/Manila')->format('g:i A') }}</td>
                            <td class="px-6 py-4">{{ $history->created_at->setTimezone('Asia/Manila')->format('F j, Y') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

</body>
</html>

@section('title')
    Payment History
@endsection

</x-app-layout>