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

    <div class="p-6">
        <table class="min-w-full mt-4 bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-white text-gray-600 uppercase font-semibold text-sm text-left border-b-2">
                <tr>
                    <th class="px-6 py-4">Patient Name</th>
                    <th class="px-6 py-4">Description</th>
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
                            <td class="px-6 py-4">{{ $payment->patientname }}</td>
                            <td class="px-6 py-4">{{ $payment->description }}</td>
                            <td class="px-6 py-4">{{ $payment->amount > 0 ? number_format($payment->amount, 0, ',', ',') : '' }}</td>
                            <td class="px-6 py-4">{{ $payment->balance == 0 ? 'Paid' : number_format($payment->balance, 0, ',', ',') }}</td>
                            <td class="px-6 py-4">{{ date('F j, Y', strtotime($payment->date)) }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('patient.paymentHistory', $payment->id) }}" class="px-4 py-2 text-white bg-blue-600 rounded cursor-pointer">History</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    
</body>
</html>

@section('title')
    Payment Info
@endsection

</x-app-layout>
