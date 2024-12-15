<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>
<body>

    <div class="p-6">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 pb-0">
                <h1 class="font-semibold text-gray-700"><a href="{{ route('admin.inventory') }}" class="underline">Inventory</a> / Item: {{ $item->item_name }}</h1>
                <h1 class="text-center text-xl sm:text-2xl lg:text-3xl font-bold">Dispose History</h1>
            </div>
            
            <div class="p-6">
                <table id="dispose-content" class="hover min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th>Reason</th>
                            <th>Expiration Date</th>
                            <th>Quantity</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($disposes as $dispose)
                            <tr>
                                <td>{{ $dispose->reason }}</td>
                                <td>{{ $dispose->expiration_date ? date('F j, Y', strtotime($dispose->expiration_date)) : 'N/A' }}</td>
                                <td>{{ number_format($dispose->disposequantity) }}</td>
                                <td>{{ $dispose->created_at ? date('F j, Y', strtotime($dispose->created_at)) : 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- TABLE -->
    <script>
        $(document).ready(function() {
            // Initialize the DataTable
            new DataTable('#dispose-content', {
                "language": {
                    "emptyTable": "No items found.", // When table is empty
                    "zeroRecords": "No matching items found.", // When search yields no results
                }
            });

            $('#dispose-content_length select').addClass('w-20');
            $('.dataTables_length').addClass('mb-4'); // Bottom margin for entries per page dropdown
            $('.dataTables_filter').addClass('mb-4');
        });
    </script>

</body>
</html>

@section('title')
    Dispose History
@endsection

</x-app-layout>