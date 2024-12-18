<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>
<body>

    <!-- INVENTORY PRINT -->
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

                <button onclick="printInventory();" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 focus:outline-none">
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

    <!-- PATIENT LIST PRINT -->
    <div class="p-6">
        <h1 class="p-2 text-lg font-semibold">Patient List</h1>
        <div class="flex items-center justify-between gap-6 p-6 bg-white shadow-lg rounded-xl">
          
            <!-- Start Date -->
            <div class="w-full">
                <label for="patientlist-start-date" class="block text-sm font-semibold text-gray-700">Start Date</label>
                <input type="date" id="patientlist-start-date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- End Date -->
            <div class="w-full">
                <label for="patientlist-end-date" class="block text-sm font-semibold text-gray-700">End Date</label>
                <input type="date" id="patientlist-end-date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-4 w-1/5 justify-start sm:justify-end">
                <button id="patientlist-clear-filters" class="bg-gray-300 px-4 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-400 focus:outline-none">
                    Clear Filters
                </button>

                <button onclick="printPatientList();" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 focus:outline-none">
                    Print Report
                </button>
            </div>
        </div>
    </div>

    <table id="patientlist" class="hidden">
        <thead>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Birthday</th>
                <th>Age</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patientlist as $patient)
                <tr>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ date('F j, Y', strtotime($patient->birthday)) }}</td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ $patient->address }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->created_at ? date('F j, Y', strtotime($patient->created_at)) : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- APPOINTMENT PRINT -->
    <div class="p-6">
        <h1 class="p-2 text-lg font-semibold">Appointment</h1>
        <div class="flex items-center justify-between gap-6 p-6 bg-white shadow-lg rounded-xl">
            <!-- Report Selection -->
            <div class="status w-full">
                <label for="status-selector" class="block text-sm font-semibold text-gray-700">Select Status</label>
                <select id="status-selector" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="" disabled selected>Select report</option>
                    <option value="All">All</option>
                    <option value="Pending">Pending report</option>
                    <option value="Approved">Approved report</option>
                    <option value="Completed">Completed report</option>
                    <option value="Cancelled">Cancelled report</option>
                </select>
            </div>

            <!-- Start Date -->
            <div class="w-full">
                <label for="appointment-start-date" class="block text-sm font-semibold text-gray-700">Start Date</label>
                <input type="date" id="appointment-start-date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- End Date -->
            <div class="w-full">
                <label for="appointment-end-date" class="block text-sm font-semibold text-gray-700">End Date</label>
                <input type="date" id="appointment-end-date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-4 w-1/5 justify-start sm:justify-end">
                <button id="appointment-clear-filters" class="bg-gray-300 px-4 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-400 focus:outline-none">
                    Clear Filters
                </button>

                <button onclick="printAppointment();" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 focus:outline-none">
                    Print Report
                </button>
            </div>
        </div>
    </div>

    <table id="appointment" class="hidden">
        <thead>
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Procedure</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calendars as $calendar)
                <tr>
                    <td>{{ in_array($calendar->status, ['PendingCancelled', 'ApprovedCancelled']) ? 'Cancelled' : $calendar->status }}</td>
                    <td>{{ $calendar->name }}</td>
                    <td>{{ $calendar->appointmentdate }}</td>
                    <td>{{ $calendar->appointmenttime }}</td>
                    <td>{{ $calendar->procedure }}</td>
                    <td>{{ $calendar->created_at ? date('F j, Y', strtotime($calendar->created_at)) : 'N/A' }}</td>
                </tr>
            @endforeach
            
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- TABLE FOR INVENTORY -->
    <script>
        function parseDate(dateString) {
            const date = new Date(dateString);
            return new Date(date.getFullYear(), date.getMonth(), date.getDate()); // Remove time component
        }

        $(document).ready(function() {
            const tables = {
                "inventory-content": $('#inventory-content').DataTable({ 
                    paging: false, 
                    lengthChange: false, 
                    info: false,
                    "columnDefs": [
                        { "targets": 8, "visible": false }  // Hide the "Created At" column in inventory-content
                    ]
                }),
                "addstock-content": $('#addstock-content').DataTable({ 
                    paging: false, 
                    lengthChange: false, 
                    info: false,
                    "columnDefs": [
                        { "targets": 3, "visible": false }  // Hide the "Created At" column in addstock-content
                    ]
                }),
                "issuance-content": $('#issuance-content').DataTable({ 
                    paging: false, 
                    lengthChange: false, 
                    info: false,
                    "columnDefs": [
                        { "targets": 3, "visible": false }  // Hide the "Created At" column in issuance-content
                    ]
                }),
                "dispose-content": $('#dispose-content').DataTable({ 
                    paging: false, 
                    lengthChange: false, 
                    info: false,
                    "columnDefs": [
                        { "targets": 3, "visible": false }  // Hide the "Created At" column in dispose-content
                    ]
                }),
            };

            // Initially hide all dataTable filters
            $('.dataTables_filter').addClass('hidden');

            // Apply filtering based on type
            $('#type').on('change', function () {
                const selectedTable = $('#table-selector').val();
                tables[selectedTable].column(1).search(this.value).draw();
            });

            // Date range filter logic
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const selectedTable = $('#table-selector').val();
                if (!selectedTable) return true;  // Skip if no table is selected

                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();
                
                if (!startDate && !endDate) return true;  // Allow all data if no dates are set

                const start = startDate ? parseDate(startDate) : null;
                const end = endDate ? parseDate(endDate) : null;
                
                // Get the created date column index for each table (adjust if different)
                const createdDateIndex = selectedTable === 'inventory-content' ? 8 :
                                        selectedTable === 'addstock-content' ? 3 :
                                        selectedTable === 'issuance-content' ? 3 :
                                        selectedTable === 'dispose-content' ? 3 : -1;

                // Get the created date from the current row (assuming it's in the right format)
                const createdDate = parseDate(data[createdDateIndex]);

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

            // Redraw tables whenever the date range changes
            $('#start-date, #end-date').on('change', function() {
                const selectedTable = $('#table-selector').val();
                if (selectedTable) {
                    tables[selectedTable].draw();
                }
            });

            // Reset all filters when the "Clear Filters" button is clicked
            $('#clear-filters').on('click', function() {
                $('#table-selector').val('');
                $('#type').val('');
                $('#start-date').val('');
                $('#end-date').val('');
                
                const selectedTable = $('#table-selector').val();
                if (selectedTable) {
                    tables[selectedTable].search('').draw();
                    tables[selectedTable].column(1).search('').draw();
                    tables[selectedTable].draw();
                }
            });
        });
    </script>

    <!-- PRINT INVENTORY -->
    <script>
        // Function to open the print view in a new tab
        function printInventory() {
            const selectedTable = $('#table-selector').val();
            const table = document.getElementById(selectedTable);
            const tableContent = table.querySelector('tbody').innerHTML; // Get the tbody content of the selected table
            
            const startDate = $('#start-date').val();
            const endDate = $('#end-date').val();

            const printDate = new Date();
            const printedDate = printDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

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
            printWindow.document.write('<div class="print-date">' + printedDate + '</div>');
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

    <!-- TABLE FOR PATIENTLIST -->
    <script>
        function parseDate(dateString) {
            const date = new Date(dateString);
            return new Date(date.getFullYear(), date.getMonth(), date.getDate()); // Remove time component
        }

        $(document).ready(function() {
            // Initialize the DataTable and store the reference in `table`
            const table = new DataTable('#patientlist', {
                "paging": false,         // Disable pagination
                "lengthChange": false,   // Disable length change dropdown
                "info": false,           // Disable table info (e.g., "Showing 1 to 10 of 50 entries")
                "columnDefs": [
                    { "targets": 7, "visible": false } // Hide the "Created At" column
                ],
            });

            $('.dataTables_filter').addClass('hidden');

            // Date range and status filter logic
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const patientliststartDate = $('#patientlist-start-date').val();
                const patientlistendDate = $('#patientlist-end-date').val();

                // Get the created date from the current row (assuming it's in the "Created At" column at index 7)
                const patientlistcreatedDate = parseDate(data[7]); // Column index for "Created At"

                // If no date range is selected, show all rows
                if (!patientliststartDate && !patientlistendDate) {
                    return true;
                }

                // Parse start and end dates for comparison
                const startDate = patientliststartDate ? parseDate(patientliststartDate) : null;
                const endDate = patientlistendDate ? parseDate(patientlistendDate) : null;

                // Filter by start date (if set)
                if (startDate && patientlistcreatedDate < startDate) {
                    return false; // Hide row if created date is before the start date
                }

                // Filter by end date (if set)
                if (endDate && patientlistcreatedDate > endDate) {
                    return false; // Hide row if created date is after the end date
                }

                return true; // Show the row if it's within the selected date range
            });

            // Redraw table when the date range changes
            $('#patientlist-start-date, #patientlist-end-date').on('change', function() {
                table.draw();
            });

            // Clear Filters functionality
            $('#patientlist-clear-filters').click(function() {
                $('#patientlist-start-date').val('');
                $('#patientlist-end-date').val('');
                table.draw(); // Reapply filters after clearing
            });
        });
    </script>

    <!-- PRINT PATIENT LIST -->
    <script>
        // Function to open the print view in a new tab
        function printPatientList() {
            const patientliststartDate = $('#patientlist-start-date').val();
            const patientlistendDate = $('#patientlist-end-date').val();

            const patientlistprintDate = new Date();
            const patientlistprintedDate = patientlistprintDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

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
            printWindow.document.write('<div class="table-title"> Patient List </div>');
            printWindow.document.write('<div class="print-date">' + patientlistprintedDate + '</div>');
            printWindow.document.write('<div class="date-range">Date Range: ' + patientliststartDate + ' - ' + patientlistendDate + '</div>');
            printWindow.document.write('</div>'); // End date range container

            // Table content
            printWindow.document.write('<table class="print-content">');
            printWindow.document.write('<thead>' + document.querySelector('#patientlist thead').innerHTML + '</thead>'); // Copy the thead

            // Loop through the visible rows after the DataTable has filtered them
            var tableRows = document.querySelectorAll('#patientlist tbody tr');
            tableRows.forEach(function(row) {
                if (row.style.display !== 'none') {
                    printWindow.document.write('<tbody>' + row.innerHTML + '</tbody>');
                }
            });

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
            printWindow.document.write('function enableContentAndPrint() { window.print(); }');
            printWindow.document.write('</' + 'script>');

            printWindow.document.close(); // Close the document to render the content
        }
    </script>

    <!-- TABLE FOR APPOINTMENT -->
    <script>
        function parseDate(dateString) {
            const date = new Date(dateString);
            return new Date(date.getFullYear(), date.getMonth(), date.getDate()); // Remove time component
        }
        
        $(document).ready(function() {
            const table = new DataTable('#appointment', {
                paging: false,         // Disable pagination
                lengthChange: false,   // Disable length change dropdown
                info: false,           // Disable table info (e.g., "Showing 1 to 10 of 50 entries")
                "columnDefs": [
                    { "targets": 5, "visible": false } // Hide the "Created At" column
                ],
            });

            // Hide the default DataTables search box
            $('.dataTables_filter').addClass('hidden');

            // Date range and status filter logic
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const selectedStatus = $('#status-selector').val();
                const appointmentstartDate = $('#appointment-start-date').val();
                const appointmentendDate = $('#appointment-end-date').val();
                
                // Get the status and created date from the current row
                const status = data[0]; // Status column index is 0 (assuming the Status is the first column)
                const appointmentcreatedDate = parseDate(data[5]); // Created At column index is 5 (assuming it's the 6th column)

                // Filter by status (allow all if "All" is selected)
                if (selectedStatus && selectedStatus !== 'All' && status !== selectedStatus) {
                    return false; // Skip row if status doesn't match the selected one
                }

                // Date range filter logic
                if (appointmentstartDate && !appointmentendDate && appointmentcreatedDate >= parseDate(appointmentstartDate)) {
                    return true; // Show rows if the created date is greater than or equal to the start date
                }

                if (appointmentstartDate && appointmentendDate) {
                    const appointmentend = parseDate(appointmentendDate);
                    if (appointmentcreatedDate >= parseDate(appointmentstartDate) && appointmentcreatedDate <= appointmentend) {
                        return true; // Show rows if the created date is within the range
                    }
                }

                // Allow all rows if no date range is set
                return !appointmentstartDate && !appointmentendDate;
            });

            // Redraw table when the date range changes
            $('#appointment-start-date, #appointment-end-date, #status-selector').on('change', function() {
                table.draw();
            });

            // Clear Filters functionality
            $('#appointment-clear-filters').click(function() {
                $('#appointment-start-date').val('');
                $('#appointment-end-date').val('');
                $('#status-selector').val(''); // Reset status to default
                table.draw(); // Reapply filters after clearing
            });
        });
    </script>

    <!-- PRINT APPOINTMENT -->
    <script>
        // Function to open the print view in a new tab
        function printAppointment() {
            const appointmentstartDate = $('#appointment-start-date').val();
            const appointmentendDate = $('#appointment-end-date').val();

            const appointmentprintDate = new Date();
            const appointmentprintedDate = appointmentprintDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

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
            printWindow.document.write('<div class="table-title"> Appointment List </div>');
            printWindow.document.write('<div class="print-date">' + appointmentprintedDate + '</div>');
            printWindow.document.write('<div class="date-range">Date Range: ' + appointmentstartDate + ' - ' + appointmentendDate + '</div>');
            printWindow.document.write('</div>'); // End date range container

            // Table content
            printWindow.document.write('<table class="print-content">');
            printWindow.document.write('<thead>' + document.querySelector('#appointment thead').innerHTML + '</thead>'); // Copy the thead

            // Loop through the visible rows after the DataTable has filtered them
            var tableRows = document.querySelectorAll('#appointment tbody tr');
            tableRows.forEach(function(row) {
                if (row.style.display !== 'none') {
                    printWindow.document.write('<tbody>' + row.innerHTML + '</tbody>');
                }
            });

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
            printWindow.document.write('function enableContentAndPrint() { window.print(); }');
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