<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>
<body class="min-h-screen">
    
    <!-- <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white">
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-money-bills"></i> Payment Information / {{ $paymentInfo->name }}</h4>
    </div> -->

    <div class="p-6">    
        <div class="p-6 bg-white shadow rounded-lg">
            <table id="paymenthistory" class="hover bg-white border border-gray-300">
                <h1 class="text-2xl font-bold mb-4">Payment History</h1>
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymenthistories as $history)
                        <tr>
                            <td>{{ number_format($history->payment, 0, ',', ',') }}</td>
                            <td>{{ $history->created_at->setTimezone('Asia/Manila')->format('F j, Y') }} </td>
                            <td>{{ $history->created_at->setTimezone('Asia/Manila')->format('g:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- TABLE -->
    <script>
        $(document).ready(function() {
            new DataTable('#paymenthistory', {
                "language": {
                    "emptyTable": "No payment history found.",
                    "zeroRecords": "No matching payment history found.",
                }
            });

            $('#paymenthistory_length select').addClass('w-20');
            $('.dataTables_length').addClass('mb-4');
            $('.dataTables_filter').addClass('mb-4');
        });
    </script>

</body>
</html>

@section('title')
    Payment History
@endsection

</x-app-layout>