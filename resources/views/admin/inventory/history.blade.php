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
        <h4>Inventory / {{ $inventory->item_name }} / Current Quantity = {{ $inventory->quantity }}</h4>
    </div>

    <div class="px-6">
        <table class="min-w-full mt-4 bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-600 uppercase font-semibold text-sm text-left">
                <tr>
                    <th class="px-6 py-3">Quantity</th>
                    <th class="px-6 py-3">Action</th>
                    <th class="px-6 py-3">Time</th>
                    <th class="px-6 py-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @if($histories->isEmpty())
                    <tr>
                        <td class="px-6 py-4 text-gray-600" colspan="3">No history found.</td>
                    </tr>
                @else
                    @foreach ($histories as $history)
                        <tr class="hover:bg-gray-100 transition duration-300">
                            <td class="px-6 py-4">{{ $history->quantity }}</td>
                            <td class="px-6 py-4">{{ $history->action }}</td>
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
    Inventory History
@endsection

</x-app-layout>