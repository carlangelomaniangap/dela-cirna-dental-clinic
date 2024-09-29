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
        <h4><i class="fa-solid fa-money-bills"></i> My Payment Info</h4>
    </div>
            
    <div class="relative overflow-x-auto pt-8">
        <table class="min-w-full bg-white text-left rtl:text-right">
            <thead class="text-gray-800">
                <tr class="border-b-2">
                    <th scope="col" class="px-6 py-4">Description</th>
                    <th scope="col" class="px-6 py-4">Amount</th>
                    <th scope="col" class="px-6 py-4">Balance</th>
                    <th scope="col" class="px-6 py-4">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentinfo as $payment)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="px-6 py-4">{{ $payment->description }}</td>
                        <td class="px-6 py-4"><i class="fa-solid fa-peso-sign"></i>{{ $payment->amount }}</td>
                        <td class="px-6 py-4"><i class="fa-solid fa-peso-sign"></i>{{ $payment->balance }}</td>
                        <td class="px-6 py-4">{{ $payment->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>

@section('title')
    Payment Info
@endsection

</x-app-layout>