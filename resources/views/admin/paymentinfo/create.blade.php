<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <!-- <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white">
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-hand-holding-dollar"></i> Add Payment</h4>
    </div> -->

    <div class="p-6">
        <form method="post" action="{{ route('admin.payment.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm lg:text-base bg-white rounded-lg shadow-md p-6">
            
            <input type="hidden" name="dentalclinic_id" value="{{ Auth::user()->dentalclinic_id }}">    

            @csrf

            <div class="flex flex-col space-y-4">
                <div>
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

                <div>
                    <label for="name" class="font-semibold">Name</label>
                    <input type="text" class="w-full rounded-lg focus:ring-2 shadow-sm" id="name" name="name" required>
                </div>
                
                <div>
                    <label for="concern" class="font-semibold">Concern</label>
                    <input type="text" class="w-full rounded-lg focus:ring-2 shadow-sm" id="concern" name="concern" required value="{{ old('concern') }}">
                </div>
            </div>
            
            <div class="flex flex-col space-y-4">
                <div>
                    <label for="amount" class="font-semibold">Amount</label>
                    <input type="number" class="w-full rounded-lg focus:ring-2 shadow-sm" id="amount" name="amount" required value="{{ old('amount') }}">
                </div>

                <div>
                    <label for="balance" class="font-semibold">Balance</label>
                    <input type="number" class="w-full rounded-lg focus:ring-2 shadow-sm" id="balance" name="balance" required value="{{ old('balance') }}">
                </div>

                <div>
                    <label for="date" class="font-semibold">Date</label>
                    <input type="date" class="w-full rounded-lg focus:ring-2 shadow-sm" id="date" name="date" required value="{{ old('date') }}">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 text-xs lg:text-base rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300 mr-2"><i class="fa-solid fa-user-plus"></i> Add</button>
                    <a href="{{ route('admin.paymentinfo') }}" class="px-4 py-2 text-xs lg:text-base rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300"><i class="fa-regular fa-rectangle-xmark"></i> Cancel</a>
                </div>
            </div>
        </form>
    </div>

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