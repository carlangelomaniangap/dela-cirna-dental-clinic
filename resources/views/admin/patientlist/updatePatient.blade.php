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
        <h4><i class="fa-solid fa-user-pen"></i> Update Patient</h4>
    </div>

    <form method="post" action="{{ route('admin.updatedPatient', $patient->id) }}"  class="w-1/2 mx-auto bg-white rounded-lg shadow-md p-10">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="users_id" class="font-semibold">Patient Account</label>
            <select class="w-full rounded-lg focus:ring-2 shadow-sm" id="users_id" name="users_id" required>
                @foreach($users as $user)
                    @if($user->usertype !== 'admin' && $user->usertype !== 'dentistrystudent')
                        <option value="{{ $user->id }}" {{ old('users_id', $patient->users_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label for="name" class="font-semibold">Name</label>
            <input type="text" id="name" name="name" class="w-full rounded-lg focus:ring-2 shadow-sm" value="{{  old('name', $patient->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="gender" class="font-semibold">Gender</label>
            <select id="gender" name="gender" class="w-full rounded-lg focus:ring-2 shadow-sm" required>
                <option value="" disabled selected>Select your Gender</option>
                <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="birthday" class="font-semibold">Birthday</label>
            <input type="date" id="birthday" name="birthday" class="w-full rounded-lg focus:ring-2 shadow-sm" value="{{  old('birthday', $patient->birthday) }}" required>
        </div>

        <div class="mb-4">
            <label for="age" class="font-semibold">Age</label>
            <input type="number" id="age" name="age" class="w-full rounded-lg focus:ring-2 shadow-sm" value="{{  old('age', $patient->age) }}" required>
        </div>

        <div  class="mb-4">
            <label for="phone" class="font-semibold">Phone No.</label>
            <input type="tel" id="phone" name="phone" class="w-full rounded-lg focus:ring-2 shadow-sm" value="{{  old('phone', $patient->phone) }}" required>
        </div>

        <div class="mb-4">
            <label for="address" class="font-semibold">Address</label>
            <input type="text" id="address" name="address" class="w-full rounded-lg focus:ring-2 shadow-sm" value="{{  old('address', $patient->address) }}" required>
        </div>
        
        <div class="mb-4">
            <label for="email" class="font-semibold">Email</label>
            <input type="email" id="email" name="email" class="w-full rounded-lg focus:ring-2 shadow-sm" value="{{  old('email', $patient->email) }}" required>
        </div>

        <div class="text-right">
            <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-solid fa-user-pen"></i> Save</button>
            <a href="{{ route('admin.patientlist') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800"><i class="fa-regular fa-rectangle-xmark"></i> Cancel</a>
        </div>
    </form>
    
</body>
</html>

@section('title')
    Update Patient
@endsection

</x-app-layout>