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

                <div class="flex justify-end mt-6">
                    <button onclick="openPrintView();" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-2 py-1.5 rounded transition duration-300">Print a copy</button>
                </div>
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

    <!-- PRINT -->
    <script>
        // Function to open the print view in a new tab
        function openPrintView() {
            var printWindow = window.open('', '_blank'); // Open a new tab
            printWindow.document.write('<html><head><title>Dela Cirna Dental Clinic</title>');

            // Add some basic styles for printing
            printWindow.document.write('<style>body { font-family: Arial, sans-serif; padding: 20px; }');
            printWindow.document.write('h2 {text-align: center;}')
            printWindow.document.write('.print-content { width: 100%; border-collapse: collapse; margin-top: 20px; }');
            printWindow.document.write('.print-content th, .print-content td { border: 1px solid #ccc; padding: 10px; font-size: 14px; }');
            printWindow.document.write('.print-content th { background-color: #f4f4f4; }');
            printWindow.document.write('.no-print { display: block; }'); // Show the Print button
            printWindow.document.write('  .action { display: none !important; }'); // Hide update button column during print
            printWindow.document.write('{ pointer-events: none; opacity: 0.5; }'); // Disable content initially
            printWindow.document.write('@media print { .no-print { display: none; } }'); // Hide print button on print
            printWindow.document.write('</style>');

            var content = document.getElementById('dispose-content').innerHTML;
            printWindow.document.write('<body>');
            printWindow.document.write('<h5>Inventory / Item: {{ $item->item_name }}</h5>');
            printWindow.document.write('<h2 class="text-center">Dispose History</h2>');
            printWindow.document.write('<table class="print-content inactive">' + content + '</table>'); // Disable content initially
            printWindow.document.write('<div class="no-print" style="margin-top: 20px;">');
            printWindow.document.write('<button onclick="enableContentAndPrint();" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; cursor: pointer; border: none;;">Print</button>');
            printWindow.document.write('</div>'); // Print button
            printWindow.document.write('</body></html>');

            // Function to enable content and open print dialog
            printWindow.document.write('<script>');
            printWindow.document.write('function enableContentAndPrint() {');
            printWindow.document.write('    var content = document.querySelector(".print-content");');
            printWindow.document.write('    content.classList.remove("inactive");'); // Enable content
            printWindow.document.write('    window.print();'); // Open the print dialog
            printWindow.document.write('}');
            printWindow.document.write('</' + 'script>');

            printWindow.document.close();
        }
    </script>

</body>
</html>

@section('title')
    Dispose History
@endsection

</x-app-layout>