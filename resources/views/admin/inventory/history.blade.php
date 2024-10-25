<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen">
    
    <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white">
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold">Inventory / {{ $inventory->item_name }}</h4>
    </div>

    <div class="p-6">
        <div class="bg-white shadow-lg rounded-lg p-4 sm:p-6 mb-6">
            <div class="flex flex-col mb-4">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">History</h1>
            </div>

            <div class="space-y-4">
                @if($histories->isEmpty())
                    <div class="px-4 py-4 text-gray-600 text-center">No history found.</div>
                @else
                    <div class="mt-4 space-y-4 overflow-y-auto max-h-94">
                        @foreach ($histories as $history)
                            <div class="border border-gray-200 rounded-lg p-4 flex flex-col sm:flex-row justify-between items-start bg-gray-50 hover:bg-gray-100 transition duration-200">
                                <div class="flex-grow mb-2 sm:mb-0">
                                    <div class="flex justify-between text-gray-800 text-sm sm:text-base lg:text-lg">
                                        <span>{{ $history->quantity }} items</span>
                                        <span class="text-gray-600">Action: {{ $history->action }}</span>
                                    </div>
                                    <div class="text-gray-500 text-xs sm:text-sm">
                                        <span>{{ $history->created_at->setTimezone('Asia/Manila')->format('g:i A') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ $history->created_at->setTimezone('Asia/Manila')->format('F j, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

</body>
</html>

@section('title')
    Inventory History
@endsection

</x-app-layout>