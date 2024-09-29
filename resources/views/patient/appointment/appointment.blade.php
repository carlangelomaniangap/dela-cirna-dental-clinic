<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body>
    <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="header py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold ">
        <h4><i class="fa-regular fa-calendar-check"></i> Appointment</h4>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
            
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="p-6">
        <form method="post" action="{{ route('patient.calendar.store') }}" class="grid grid-cols-2 gap-6 bg-white rounded-lg shadow-md p-10">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <h3 class="text-3xl font-bold">Patient Appointment</h3>
                    <p class="text-sm">Fill out the form to schedule your appointment.</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">


                    <div>
                        <label for="appointmentdate" class="font-semibold">Appointment Date</label>
                        <input type="date" class="rounded-lg focus:ring-2 shadow-sm w-full" id="appointmentdate" name="appointmentdate" required>
                    </div>

                    <div>
                        <label for="appointmenttime" class="font-semibold time">Appointment Time</label>
                        <input type="time" class="rounded-lg focus:ring-2 shadow-sm w-full" id="appointmenttime" name="appointmenttime" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="font-semibold">Name</label>
                        <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="name" name="name" required>
                    </div>
                    <div>

                        <label for="gender" class="font-semibold">Gender</label>
                        <select id="gender" name="gender" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                            <option value="" disabled selected>Select your Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="birthday" class="font-semibold">Birthday</label>
                        <input type="date" class="rounded-lg focus:ring-2 shadow-sm w-full" id="birthday" name="birthday" required>
                    </div>
                    
                    
                    <div>
                        <label for="age" class="font-semibold">Age</label>
                        <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="age" name="age" required>
                    </div>
                </div>

                <div>
                    <label for="address" class="font-semibold">Address</label>
                    <textarea type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="address" name="address" placeholder="Type here..." required></textarea>
                </div>
                    
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="font-semibold">Phone No.</label>
                        <input type="tel" class="rounded-lg focus:ring-2 shadow-sm w-full" id="phone" name="phone" required>
                    </div>
                    
                    <div>
                        <label for="email" class="font-semibold">Email</label>
                        <input type="email" class="rounded-lg focus:ring-2 shadow-sm w-full" id="email" name="email" required>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                
                <div>
                    <label for="medicalhistory" class="font-semibold">Medical History <span class="text-gray-500">(Optional)</span></label>
                    <textarea type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="medicalhistory" name="medicalhistory" placeholder="Type here..."></textarea>
                </div>

                <div>
                    <div>
                        <h1 class="font-semibold text-xl pb-2">Emecgency Contacts</h1>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="emergencycontactname" class="font-semibold">Name</label>
                            <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactname" name="emergencycontactname" required>
                        </div>

                        <div>
                            <label for="emergencycontactrelation" class="font-semibold">Relation</label>
                            <select id="emergencycontactrelation" name="emergencycontactrelation" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                                <option value="" disabled selected>Select your Relation</option>
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Son">Son</option>
                                <option value="Daughter">Daughter</option>
                                <option value="Nephew">Nephew</option>
                                <option value="Niece">Niece</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="emergencycontactphone" class="font-semibold">Phone No.</label>
                    <input type="tel" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactphone" name="emergencycontactphone" required>
                </div>
                    
                <div>
                    <div>
                        <h1 class="font-semibold text-xl pb-3">Fill out this if you're not the patient</h1>
                    </div>
                        
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="relationname" class="font-semibold">Name <span class="text-gray-500">(Optional)</span></label>
                            <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="relationname" name="relationname">
                        </div>

                        <div>
                            <label for="relation" class="font-semibold">Relation <span class="text-gray-500">(Optional)</span></label>
                            <select id="relation" name="relation" class="rounded-lg focus:ring-2 shadow-sm w-full">
                                <option value="" disabled selected>Select your Relation</option>
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Son">Son</option>
                                <option value="Daughter">Daughter</option>
                                <option value="Nephew">Nephew</option>
                                <option value="Niece">Niece</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-regular fa-calendar-check"></i> Appoint</button>  
                </div>
            </div>
            <!-- <div class="col-span-2 flex justify-center mt-4">
                <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-regular fa-calendar-check"></i> Appoint</button>  
            </div> -->
        </form>
    </div>
</body>
</html>

@section('title')
    Appointment
@endsection

</x-app-layout>