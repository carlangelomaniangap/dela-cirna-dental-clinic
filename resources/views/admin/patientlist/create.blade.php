<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white">
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-user-plus"></i> Add Patient</h4>
    </div>

    <div class="p-4">
        <form method="post" action="{{ route('admin.patient.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm lg:text-base bg-white rounded-lg shadow-lg p-4">
            <input type="hidden" name="dentalclinic_id" value="{{ Auth::user()->dentalclinic_id }}">
            
            @csrf

            <div class="flex flex-col space-y-4">
                <div>
                    <label for="users_id" class="font-semibold text-gray-700">Patient Account</label>
                    <select class="w-full py-2 px-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" id="users_id" name="users_id" required>
                        <option value="" disabled selected>Select</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-name="{{ $user->name }}" data-gender="{{ $user->gender }}" data-birthday="{{ $user->birthday }}" data-age="{{ $user->age }}" data-address="{{ $user->address }}" data-phone="{{ $user->phone }}" data-email="{{ $user->email }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="name" class="font-semibold text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                </div>

                <div>
                    <label for="gender" class="font-semibold text-gray-700">Gender</label>
                    <select id="gender" name="gender" class="w-full py-2 px-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                        <option value="" disabled selected>Select your Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div>
                    <label for="birthday" class="font-semibold text-gray-700">Birthday</label>
                    <input type="date" id="birthday" name="birthday" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                <div>
                    <label for="age" class="font-semibold text-gray-700">Age</label>
                    <input type="number" id="age" name="age" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                </div>

                <div>
                    <label for="address" class="font-semibold text-gray-700">Address</label>
                    <input type="text" id="address" name="address" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                </div>

                <div>
                    <label for="phone" class="font-semibold text-gray-700">Phone No.</label>
                    <input type="tel" id="phone" name="phone" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                </div>

                <div>
                    <label for="email" class="font-semibold text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 text-xs lg:text-base rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300 mr-2"><i class="fa-solid fa-user-plus"></i> Add</button>
                    <a href="{{ route('admin.patientlist') }}" class="px-4 py-2 text-xs lg:text-base rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300"><i class="fa-regular fa-rectangle-xmark"></i> Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('users_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('name').value = selectedOption.getAttribute('data-name');
            document.getElementById('gender').value = selectedOption.getAttribute('data-gender');
            document.getElementById('birthday').value = selectedOption.getAttribute('data-birthday');
            document.getElementById('age').value = selectedOption.getAttribute('data-age');
            document.getElementById('address').value = selectedOption.getAttribute('data-address');
            document.getElementById('phone').value = selectedOption.getAttribute('data-phone');
            document.getElementById('email').value = selectedOption.getAttribute('data-email');
        });
    </script>

</body>
</html>

@section('title')
    New Patient
@endsection

</x-app-layout>