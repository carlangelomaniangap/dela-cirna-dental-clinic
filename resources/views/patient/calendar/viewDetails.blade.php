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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-calendar-days"></i> Appointment Details / {{ $calendar->name }}</h4>
    </div>

    @if(session('success') || $errors->any())
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="relative p-4 w-full max-w-md">
                <div class="relative p-5 text-center bg-white rounded-lg shadow">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center" onclick="this.closest('.fixed').style.display='none'">
                        <i class="fa-solid fa-xmark text-lg"></i>
                        <span class="sr-only">Close modal</span>
                    </button>

                    @if(session('success'))
                        <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-check text-green-500 text-2xl"></i>
                            <span class="sr-only">Success</span>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-full bg-red-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-xmark text-red-500 text-2xl"></i>
                            <span class="sr-only">Error</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <p class="mb-4 text-lg font-semibold text-gray-900">{{ session('success') }}</p>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="mb-4 text-lg font-semibold text-red-600">{{ $error }}</p>
                        @endforeach
                    @endif

                    @if(session('success'))
                        <button type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300" onclick="this.closest('.fixed').style.display='none'">
                            Continue
                        </button>
                    @else
                        <button type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300" onclick="this.closest('.fixed').style.display='none'">
                            Continue
                        </button>
                    @endif
                    
                </div>
            </div>
        </div>
    @endif

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white rounded-lg">
            <!-- First Column -->
            <div class="flex flex-col space-y-4 text-xs lg:text-base">
                <div class="p-4 border rounded-md">
                    <p><strong>Appointment Date:</strong> {{ date('F j, Y', strtotime($calendar->appointmentdate)) }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Appointment Time:</strong> {{ (new DateTime($calendar->appointmenttime))->format('g:i A') }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Concern:</strong> {{ $calendar->concern }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Name:</strong> {{ $calendar->name }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Gender:</strong> {{ $calendar->gender }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Birthday:</strong> {{ date('F j, Y', strtotime($calendar->birthday)) }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Age:</strong> {{ $calendar->age }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Address:</strong> {{ $calendar->address }}</p>
                </div>
            </div>

            <!-- Second Column -->
            <div class="flex flex-col space-y-4 text-xs lg:text-base">
                <div class="p-4 border rounded-md">
                    <p><strong>Phone No.:</strong> {{ $calendar->phone }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Email:</strong> {{ $calendar->email }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Medical History:</strong> {{ $calendar->medicalhistory }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Emergency Contact Name:</strong> {{ $calendar->emergencycontactname }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Emergency Contact Relation:</strong> {{ $calendar->emergencycontactrelation }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Emergency Contact Phone:</strong> {{ $calendar->emergencycontactphone }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Relation Name:</strong> {{ $calendar->relationname }}</p>
                </div>
                <div class="p-4 border rounded-md">
                    <p><strong>Relation:</strong> {{ $calendar->relation }}</p>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('patient.calendar') }}" class="px-4 py-2 text-xs lg:text-base rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300"><i class="fa-regular fa-rectangle-xmark"></i> Back</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

@section('title')
    Appointment Details
@endsection

</x-app-layout>