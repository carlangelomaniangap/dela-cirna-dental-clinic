<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body  class="min-h-screen">

    <div class="bg-[#4b9cd3;] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold">
        <h4><i class="fa-solid fa-calendar-days"></i> Appointment Details</h4>
    </div>

    <div class="p-6">
        <table class="grid grid-cols-2 gap-4 min-w-full bg-white text-left rtl:text-right rounded-lg shadow-md p-5">
            <div class="grid grid-cols-1">
                <thead class="text-gray-800 whitespace-nowrap">
                    <tr>
                        <th scope="col" class="px-6 py-3">Appointment Time</th>
                        <td class="px-6 py-3">{{ $calendar->appointmenttime }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Appointment Date</th>
                        <td class="px-6 py-3">{{ $calendar->appointmentdate }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Concern</th>
                        <td class="px-6 py-3">{{ $calendar->concern }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <td class="px-6 py-3">{{ $calendar->name }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Gender</th>
                        <td class="px-6 py-3">{{ $calendar->gender }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Birthday</th>
                        <td class="px-6 py-3">{{ $calendar->birthday }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Age</th>
                        <td class="px-6 py-3">{{ $calendar->age }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Address</th>
                        <td class="px-6 py-3">{{ $calendar->address }}</td>
                            
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Phone No.</th>
                        <td class="px-6 py-3">{{ $calendar->phone }}</td>
                            
                    </tr>
                    
                </thead>
            </div>
            <div class="grid grid-cols-1">
                <thead class="text-gray-800 whitespace-nowrap">
                    <tr>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <td class="px-6 py-3">{{ $calendar->email }}</td>
                    </tr>
                        <th scope="col" class="px-6 py-3">Medical History</th>
                        <td class="px-6 py-3">{{ $calendar->medicalhistory }}</td>
                            
                    <tr>
                        <th scope="col" class="px-6 py-3">Emergency Contact Name</th>
                        <td class="px-6 py-3">{{ $calendar->emergencycontactname }}</td>
                            
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Emergency Contact Relation</th>
                        <td class="px-6 py-3">{{ $calendar->emergencycontactrelation }}</td>
                            
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Emergency Contact Phone</th>
                        <td class="px-6 py-3">{{ $calendar->emergencycontactphone }}</td>
                            
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <td class="px-6 py-3">{{ $calendar->relationname }}</td>
                            
                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">Relation</th>
                        <td class="px-6 py-3">{{ $calendar->relation }}</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{ route('admin.updateCalendar', $calendar->id) }}" class="py-1 px-2 rounded bg-white hover:bg-gray-300 text-gray-800 mr-[5px] inline-block" title="Update"><i class="fa-solid fa-pen"></i></a>
                            <form method="post" action="{{ route('admin.deleteCalendar', $calendar->id) }}" class="mr-[5px] inline-block" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-1 px-2 rounded bg-white text-red-800 hover:bg-red-200" title="Delete" onclick="return confirm('Are you sure you want to delete this appointment?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                </thead>
                
            </div>
        </table>
    </div>

</body>
</html>

@section('title')
    Appointment Details
@endsection

</x-app-layout>