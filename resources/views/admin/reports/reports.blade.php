<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>
<body>

    <div class="p-6">
        <h1 class="p-2 text-lg font-semibold">Inventory</h1>
        <div class="filter-container flex items-center justify-between gap-6 p-6 bg-white shadow-lg rounded-xl">
            <!-- Report Selection -->
            <div class="table-selector-container w-full">
                <label for="table-selector" class="block text-sm font-semibold text-gray-700">Select Report</label>
                <select id="table-selector" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="" disabled selected>Select report</option>
                    <option value="inventory-content">Inventory report</option>
                    <option value="addstock-content">Add Stock report</option>
                    <option value="issuance-content">Issuance report</option>
                    <option value="dispose-content">Dispose report</option>
                </select>
            </div>

            <!-- Type Filter -->
            <div class="w-full">
                <label for="type" class="block text-sm font-semibold text-gray-700">Filter by Type</label>
                <select id="type" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">All</option>
                    <option value="Equipment">Equipment</option>
                    <option value="Consumable">Consumable</option>
                </select>
            </div>

            <!-- Start Date -->
            <div class="w-full">
                <label for="start-date" class="block text-sm font-semibold text-gray-700">Start Date</label>
                <input type="date" id="start-date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- End Date -->
            <div class="w-full">
                <label for="end-date" class="block text-sm font-semibold text-gray-700">End Date</label>
                <input type="date" id="end-date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-4 w-1/5 justify-start sm:justify-end">
                <button id="clear-filters" class="bg-gray-300 px-4 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-400 focus:outline-none">
                    Clear Filters
                </button>

                <button onclick="openPrintView();" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 focus:outline-none">
                    Print Report
                </button>
            </div>
        </div>
    </div>

    <table id="inventory-content" class="hidden">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Type</th>
                <th>Unit</th>
                <th>Stocks</th>
                <th>Issuance</th>
                <th>Disposed</th>
                <th>Remaining Stocks</th>
                <th>Expiration Date</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ number_format($item->stocks) }}</td>
                    <td>{{ number_format($item->issuance) }}</td>
                    <td>{{ number_format($item->disposed) }}</td>
                    <td>{{ number_format($item->remaining_stocks) }}</td>
                    <td>{{ $item->expiration_date ? date('F j, Y', strtotime($item->expiration_date)) : 'N/A' }}</td>
                    <td>{{ $item->created_at ? date('F j, Y', strtotime($item->created_at)) : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table id="addstock-content" class="hidden">
        <thead>
            <tr>
                <th>Receiver Name</th>
                <th>Expiration Date</th>
                <th>Quantity</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($addstocks as $addstock)
                <tr>
                    <td>{{ $addstock->receiver_name }}</td>
                    <td>{{ $addstock->expiration_date ? date('F j, Y', strtotime($addstock->expiration_date)) : 'N/A' }}</td>
                    <td>{{ $addstock->quantity }}</td>
                    <td>{{ $addstock->created_at ? date('F j, Y', strtotime($addstock->created_at)) : 'N/A' }}</td>
                 </tr>
            @endforeach
        </tbody>
    </table>

    <table id="issuance-content" class="hidden">
        <thead>
            <tr>
                <th>Distribute to</th>
                <th>Expiration Date</th>
                <th>Issuance</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($issuances as $issuance)
                <tr>
                    <td>{{ $issuance->distribute_to }}</td>
                    <td>{{ $issuance->expiration_date ? date('F j, Y', strtotime($issuance->expiration_date)) : 'N/A' }}</td>
                    <td>{{ number_format($issuance->issuance) }}</td>
                    <td>{{ $issuance->created_at ? date('F j, Y', strtotime($issuance->created_at)) : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table id="dispose-content" class="hidden">
        <thead>
            <tr>
                <th>Reason</th>
                <th>Expiration Date</th>
                <th>Quantity</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- TABLE -->
    <script>
        function parseDate(dateString) {
            const date = new Date(dateString);
            return new Date(date.getFullYear(), date.getMonth(), date.getDate()); // Remove time component
        }
        
        $(document).ready(function() {
            const tables = {
                "inventory-content": $('#inventory-content').DataTable({ paging: false, lengthChange: false, info: false }),
                "addstock-content": $('#addstock-content').DataTable({ paging: false, lengthChange: false, info: false }),
                "issuance-content": $('#issuance-content').DataTable({ paging: false, lengthChange: false, info: false }),
                "dispose-content": $('#dispose-content').DataTable({ paging: false, lengthChange: false, info: false }),
            };

            $('.dataTables_filter').addClass('hidden');
           
            $('#type').on('change', function () {
                const selectedTable = $('#table-selector').val();
                tables[selectedTable].column(1).search(this.value).draw();
            });

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();
                const createdAt = data[8];

                if (!startDate && !endDate) return true;

                const start = startDate ? parseDate(startDate) : null;
                const end = endDate ? parseDate(endDate) : null;

                const createdDate = parseDate(createdAt);

                if (startDate && !endDate) {
                    if (createdDate >= start) {
                        return true;
                    }
                }

                if (startDate && endDate) {
                    if (createdDate >= start && createdDate <= end) {
                        return true;
                    }
                }

                return false;
            });

            $('#start-date, #end-date').on('change', function() {
                const selectedTable = $('#table-selector').val();
                tables[selectedTable].draw();
            });

            $('#clear-filters').on('click', function() {
                $('#type').val('');
                $('#start-date').val('');
                $('#end-date').val('');
                const selectedTable = $('#table-selector').val();
                tables[selectedTable].search('').draw();
                tables[selectedTable].column(1).search('').draw();
                tables[selectedTable].draw();
            });
        });
    </script>

    <!-- PRINT -->
    <script>
        // Function to open the print view in a new tab
        function openPrintView() {
            const selectedTable = $('#table-selector').val();
            const table = document.getElementById(selectedTable);
            const tableContent = table.querySelector('tbody').innerHTML; // Get the tbody content of the selected table
            
            const startDate = $('#start-date').val();
            const endDate = $('#end-date').val();

            let TableTitle;
            if (selectedTable === "inventory-content") {
                TableTitle = "Inventory Report";
            } else if (selectedTable === "addstock-content") {
                TableTitle = "Add Stock Report";
            } else if (selectedTable === "issuance-content") {
                TableTitle = "Issuance Report";
            } else if (selectedTable === "dispose-content") {
                TableTitle = "Dispose Report";
            }

            // Capture the admin's username (replace with your dynamic method)
            var username = '{{ Auth::user()->name }}'; // For Laravel: Authenticated admin username

            var printWindow = window.open('', '_blank'); // Open a new tab
            printWindow.document.write('<html><head><title>Dela Cirna Dental Clinic</title>');
            
            // Add styles for printing
            printWindow.document.write('<style>');
            printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; margin: 0; }');
            printWindow.document.write('.print-content { width: 100%; border-collapse: collapse; margin-top: 20px; }');
            printWindow.document.write('.print-content th, .print-content td { border: 1px solid #ccc; padding: 10px; font-size: 14px; }');
            printWindow.document.write('.print-content th { background-color: #f4f4f4; }');
            printWindow.document.write('.no-print { display: block; }'); // Show the Print button
            printWindow.document.write('@media print { .no-print { display: none; } }'); // Hide print button on print
            printWindow.document.write('.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid black; }');
            printWindow.document.write('.header .logo { width: 80px; height: auto; }');
            printWindow.document.write('.header .company-info { text-align: left; font-size: 14px; }');
            printWindow.document.write('.header .clinic-name { font-size: 24px; font-weight: bold; }'); // Larger clinic name
            printWindow.document.write('.footer { position: fixed; bottom: 20px; width: 100%; text-align: center; }');
            printWindow.document.write('.footer .signature { margin-top: 50px; font-size: 14px; }');
            
            // Date Range and Title Styling
            printWindow.document.write('.date-range-container { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }');
            printWindow.document.write('.table-title { font-size: 18px; font-weight: bold; text-align: left; }');
            printWindow.document.write('.date-range { font-size: 14px; text-align: right; }'); // Date Range Style
            
            // Signature Styling
            printWindow.document.write('.signature-space { margin-top: 50px; text-align: center; font-size: 16px; }');
            printWindow.document.write('.signature-line { font-weight: lighter; }');
            printWindow.document.write('.signature-name { font-weight: bold; font-size: 16px; margin-top: 10px; }');
            
            printWindow.document.write('</style>');

            // Write the body content including the table and the print button
            printWindow.document.write('<body>');

            // Header with company info and logo
            printWindow.document.write('<div class="header">');
            printWindow.document.write('<div class="company-info">');
            printWindow.document.write('<div class="clinic-name">Dela Cirna Dental Clinic</div>'); // Clinic name with larger font
            printWindow.document.write('Old National Road, Mulawin, Orani, Bataan<br>');
            printWindow.document.write('info@bataandental.com');
            printWindow.document.write('</div>');
            printWindow.document.write('<img class="logo" src="{{ asset('images/logo.png') }}" alt="Dela Cirna Dental Clinic Logo">');
            printWindow.document.write('</div>'); // End header

            // Date Range and Title
            printWindow.document.write('<div class="date-range-container">');
            printWindow.document.write('<div class="table-title">' + TableTitle + '</div>');
            printWindow.document.write('<div class="date-range">Date Range: ' + startDate + ' - ' + endDate + '</div>');
            printWindow.document.write('</div>'); // End date range container

            // Table content
            printWindow.document.write('<table class="print-content">');
            printWindow.document.write('<thead>' + table.querySelector('thead').innerHTML + '</thead>'); // Copy the thead
            printWindow.document.write('<tbody>' + tableContent + '</tbody>'); // Insert the tbody content
            printWindow.document.write('</table>');
            
            // Signature Space
            printWindow.document.write('<div class="signature-space">');
            printWindow.document.write('<div class="signature-line">____________________________</div>'); // Signature line
            printWindow.document.write('<div class="signature-name">' + username + '</div>'); // User's name (admin)
            printWindow.document.write('</div>'); // End signature space
            
            // Print button
            printWindow.document.write('<div class="no-print" style="margin-top: 20px;">');
            printWindow.document.write('<button onclick="enableContentAndPrint();" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; cursor: pointer; border: none;">Print</button>');
            printWindow.document.write('</div>'); // Print button

            printWindow.document.write('</body></html>');

            // Function to enable content and open print dialog
            printWindow.document.write('<script>');
            printWindow.document.write('function enableContentAndPrint() {');
            printWindow.document.write('    window.print();'); // Open the print dialog
            printWindow.document.write('}');
            printWindow.document.write('</' + 'script>');

            printWindow.document.close(); // Close the document to render the content
        }
    </script>

</body>
</html>

@section('title')
    Reports
@endsection

</x-app-layout>