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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-money-bills"></i> Payment Information</h4>
    </div> -->

    <div class="p-6">
        <div class="p-6 bg-white shadow rounded-lg">
            <h1 class="text-2xl font-bold mb-4">Payment Information</h1>
            <table id="paymentinformation" class="hover bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Concern</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentinfo as $payment)
                        <tr class="text-sm sm:text-base">
                            <td>{{ $payment->name }}</td>
                            <td>{{ $payment->concern }}</td>
                            <td>{{ $payment->amount > 0 ? number_format($payment->amount, 0, ',', ',') : 'N/A' }}</td>
                            <td>{{ $payment->balance == 0 ? 'Paid' : number_format($payment->balance, 0, ',', ',') }}</td>
                            <td>{{ date('F j, Y', strtotime($payment->date)) }}</td>
                            <td>
                                <a href="{{ route('patient.paymentHistory', $payment->id) }}" class="px-2 sm:px-4 py-2 text-white text-sm sm:text-base bg-blue-600 hover:bg-blue-800 transition duration-300 rounded">
                                    <i class="fas fa-history"></i> History
                                </a>
                            </td>
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
            new DataTable('#paymentinformation', {
                "language": {
                    "emptyTable": "No payment information found.",
                    "zeroRecords": "No matching payment information found.",
                }
            });

            $('#paymentinformation_length select').addClass('w-20');
            $('.dataTables_length').addClass('mb-4');
            $('.dataTables_filter').addClass('mb-4');
        });
    </script>
    
</body>
</html>

@section('title')
    Payment Information
@endsection

</x-app-layout>
