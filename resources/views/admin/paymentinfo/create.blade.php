<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div class="bg-[#4b9cd3;] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-10">
        <h4><i class="fa-solid fa-hand-holding-dollar"></i> Add Payment</h4>
    </div>
    
    <form method="post" action="{{ route('admin.payment.store') }}" class="w-1/2 mx-auto bg-white rounded-lg shadow-md p-10">
        <input type="hidden" name="dentalclinic_id" value="{{ Auth::user()->dentalclinic_id }}">    

        @csrf

        <div class="mb-4">
            <label for="users_id" class="font-semibold">Patient Account</label>
            <select class="w-full rounded-lg focus:ring-2 shadow-sm" id="users_id" name="users_id" required>
                <option value="" disabled selected>Select</option>
                @foreach($users as $user)
                    @if($user->usertype !== 'admin' && $user->usertype !== 'dentistrystudent')
                        <option value="{{ $user->id }}" data-name="{{ $user->name }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="name" class="font-semibold">Name</label>
            <input type="text" class="w-full rounded-lg focus:ring-2 shadow-sm" id="name" name="name" required>
        </div>
        
        <div class="mb-4">
            <label for="concern" class="font-semibold">Concern</label>
            <input type="text" class="w-full rounded-lg focus:ring-2 shadow-sm" id="concern" name="concern" required value="{{ old('concern') }}">
        </div>

        <div class="mb-4 form-inline">
            <label for="amount" class="font-semibold">Amount</label>
            <input type="number" class="w-full rounded-lg focus:ring-2 shadow-sm" id="amount" name="amount" required value="{{ old('amount') }}">
        </div>

        <div class="mb-4 form-inline">
            <label for="balance" class="font-semibold">Balance</label>
            <input type="number" class="w-full rounded-lg focus:ring-2 shadow-sm" id="balance" name="balance" required value="{{ old('balance') }}">
        </div>

        <div class="mb-4">
            <label for="date" class="font-semibold">Date</label>
            <input type="date" class="w-full rounded-lg focus:ring-2 shadow-sm" id="date" name="date" required value="{{ old('date') }}">
        </div>

        <div class="text-right">
            <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-solid fa-plus"></i> Add</button>
            <a href="{{ route('admin.paymentinfo') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800"><i class="fa-regular fa-rectangle-xmark"></i> Cancel</a>
        </div>
    </form>

    <script>
        document.getElementById('users_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('name').value = selectedOption.getAttribute('data-name');
        });
    </script>

</body>
</html>

@section('title')
    Add Payment Info
@endsection

</x-app-layout>