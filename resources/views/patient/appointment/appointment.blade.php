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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-regular fa-calendar-check"></i> Appointment</h4>
    </div> -->
    
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
        <form method="post" action="{{ route('patient.calendar.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white rounded-lg shadow-md p-6">
            
            <input type="hidden" name="dentalclinic_id" value="{{ Auth::user()->dentalclinic_id }}">
            
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-base lg:text-2xl font-bold">Patient Appointment</h3>
                    <p class="text-xs lg:text-sm">Fill out the form to schedule your appointment.</p>
                </div>
                
                <div>
                    <label for="appointmentdate" class="text-sm lg:text-base font-semibold">Appointment Date</label>
                    <input type="date" class="rounded-lg focus:ring-2 shadow-sm w-full" id="appointmentdate" name="appointmentdate" value="{{ old('appointmentdate') }}" required>
                </div>

                <div>
                    <label for="appointmenttime" class="text-sm lg:text-base font-semibold">Appointment Time</label>
                    <select id="appointmenttime" name="appointmenttime" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                        <option value="" disabled selected>Select your Time</option>
                        <option value="08:00:00" {{ old('appointmenttime') == '08:00:00' ? 'selected' : '' }}>8:00 AM - 9:00 AM</option>
                        <option value="09:00:00" {{ old('appointmenttime') == '09:00:00' ? 'selected' : '' }}>9:00 AM - 10:00 AM</option>
                        <option value="10:00:00" {{ old('appointmenttime') == '10:00:00' ? 'selected' : '' }}>10:00 AM - 11:00 AM</option>
                        <option value="11:00:00" {{ old('appointmenttime') == '11:00:00' ? 'selected' : '' }}>11:00 AM - 12:00 PM</option>
                        <option value="15:00:00" {{ old('appointmenttime') == '15:00:00' ? 'selected' : '' }}>3:00 PM - 4:00 PM</option>
                        <option value="16:00:00" {{ old('appointmenttime') == '16:00:00' ? 'selected' : '' }}>4:00 PM - 5:00 PM</option>
                        <option value="17:00:00" {{ old('appointmenttime') == '17:00:00' ? 'selected' : '' }}>5:00 PM - 6:00 PM</option>
                        <option value="18:00:00" {{ old('appointmenttime') == '18:00:00' ? 'selected' : '' }}>6:00 PM - 7:00 PM</option>
                        <option value="19:00:00" {{ old('appointmenttime') == '19:00:00' ? 'selected' : '' }}>7:00 PM - 8:00 PM</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="concern" class="text-sm lg:text-base font-semibold">Concern</label>
                    <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="concern" name="concern" value="{{ old('concern') }}" placeholder="e.g., Cleaning, Pasta, Braces" required>
                </div>
                
                <input type="hidden" name="name" value="{{ auth()->user()->name }}">

                <input type="hidden" name="gender" value="{{ auth()->user()->gender }}">

                <input type="hidden" name="birthday" value="{{ auth()->user()->birthday }}">
                    
                <input type="hidden" name="age" value="{{ auth()->user()->age }}">

                <input type="hidden" name="address" value="{{ auth()->user()->address }}">
                
                <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
                    
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                <div class="col-span-1 md:col-span-2">
                    <label for="medicalhistory" class="text-sm lg:text-base font-semibold">Medical History <span class="text-gray-500">(Optional)</span></label>
                    <textarea class="rounded-lg focus:ring-2 shadow-sm w-full" id="medicalhistory" name="medicalhistory" placeholder="Type here...">{{ old('medicalhistory', auth()->user()->medicalhistory) }}</textarea>
                </div>
            </div>


            

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-1 md:col-span-2">
                    <h1 class="font-semibold text-base lg:text-lg">Emergency Contacts</h1>
                </div>
                
                <div>
                    <label for="emergencycontactname" class="text-sm lg:text-base font-semibold">Name</label>
                    <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactname" name="emergencycontactname" value="{{ old('emergencycontactname') }}" required>
                </div>

                 <div>
                    <label for="emergencycontactrelation" class="text-sm lg:text-base font-semibold">Relation</label>
                    <select id="emergencycontactrelation" name="emergencycontactrelation" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                        <option value="" disabled selected>Select your Relation</option>
                        <option value="Great-grandfather" {{ old('emergencycontactrelation') == 'Great-grandfather' ? 'selected' : '' }}>Great-grandfather</option>
                        <option value="Great-grandmother" {{ old('emergencycontactrelation') == 'Great-grandmother' ? 'selected' : '' }}>Great-grandmother</option>
                        <option value="Great-grandson" {{ old('emergencycontactrelation') == 'Great-grandson' ? 'selected' : '' }}>Great-grandson</option>
                        <option value="Great-granddaughter" {{ old('emergencycontactrelation') == 'Great-granddaughter' ? 'selected' : '' }}>Great-granddaughter</option>
                        <option value="GrandFather" {{ old('emergencycontactrelation') == 'GrandFather' ? 'selected' : '' }}>Grand Father</option>
                        <option value="GrandMother" {{ old('emergencycontactrelation') == 'GrandMother' ? 'selected' : '' }}>Grand Mother</option>
                        <option value="Grandson" {{ old('emergencycontactrelation') == 'Grandson' ? 'selected' : '' }}>Grandson</option>
                        <option value="Granddaughter" {{ old('emergencycontactrelation') == 'Granddaughter' ? 'selected' : '' }}>Granddaughter</option>
                        <option value="Father" {{ old('emergencycontactrelation') == 'Father' ? 'selected' : '' }}>Father</option>
                        <option value="Mother" {{ old('emergencycontactrelation') == 'Mother' ? 'selected' : '' }}>Mother</option>
                        <option value="Spouse" {{ old('emergencycontactrelation') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                        <option value="Uncle" {{ old('emergencycontactrelation') == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                        <option value="Auntie" {{ old('emergencycontactrelation') == 'Auntie' ? 'selected' : '' }}>Auntie</option>
                        <option value="Brother" {{ old('emergencycontactrelation') == 'Brother' ? 'selected' : '' }}>Brother</option>
                        <option value="Sister" {{ old('emergencycontactrelation') == 'Sister' ? 'selected' : '' }}>Sister</option>
                        <option value="Son" {{ old('emergencycontactrelation') == 'Son' ? 'selected' : '' }}>Son</option>
                        <option value="Daughter" {{ old('emergencycontactrelation') == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                        <option value="Nephew" {{ old('emergencycontactrelation') == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                        <option value="Niece" {{ old('emergencycontactrelation') == 'Niece' ? 'selected' : '' }}>Niece</option>
                        <option value="Cousin" {{ old('emergencycontactrelation') == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                        <option value="Father-in-law" {{ old('emergencycontactrelation') == 'Father-in-law' ? 'selected' : '' }}>Father-in-law</option>
                        <option value="Mother-in-law" {{ old('emergencycontactrelation') == 'Mother-in-law' ? 'selected' : '' }}>Mother-in-law</option>
                        <option value="Brother-in-law" {{ old('emergencycontactrelation') == 'Brother-in-law' ? 'selected' : '' }}>Brother-in-law</option>
                        <option value="Sister-in-law" {{ old('emergencycontactrelation') == 'Sister-in-law' ? 'selected' : '' }}>Sister-in-law</option>
                        <option value="Son-in-law" {{ old('emergencycontactrelation') == 'Son-in-law' ? 'selected' : '' }}>Son-in-law</option>
                        <option value="Daughter-in-law" {{ old('emergencycontactrelation') == 'Daughter-in-law' ? 'selected' : '' }}>Daughter-in-law</option>
                        <option value="Stepfather" {{ old('emergencycontactrelation') == 'Stepfather' ? 'selected' : '' }}>Stepfather</option>
                        <option value="Stepmother" {{ old('emergencycontactrelation') == 'Stepmother' ? 'selected' : '' }}>Stepmother</option>
                        <option value="Stepbrother" {{ old('emergencycontactrelation') == 'Stepbrother' ? 'selected' : '' }}>Stepbrother</option>
                        <option value="Stepsister" {{ old('emergencycontactrelation') == 'Stepsister' ? 'selected' : '' }}>Stepsister</option>
                        <option value="Half-brother" {{ old('emergencycontactrelation') == 'Half-brother' ? 'selected' : '' }}>Half-brother</option>
                        <option value="Half-sister" {{ old('emergencycontactrelation') == 'Half-sister' ? 'selected' : '' }}>Half-sister</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="emergencycontactphone" class="text-sm lg:text-base font-semibold">Phone No.</label>
                    <input type="tel" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactphone" name="emergencycontactphone" value="{{ old('emergencycontactphone') }}" placeholder="e.g., 09123456789" required>
                </div>
                
                <div class="col-span-1 md:col-span-2">
                    <h1 class="font-semibold text-base lg:text-lg">Fill out this if you're not the patient</h1>
                </div>
                
                <div>
                    <label for="relationname" class="text-sm lg:text-base font-semibold">Name <span class="text-gray-500">(Optional)</span></label>
                    <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="relationname" name="relationname" value="{{ old('relationname') }}">
                </div>

                <div>
                    <label for="relation" class="text-sm lg:text-base font-semibold">Relation <span class="text-gray-500">(Optional)</span></label>
                    <select id="relation" name="relation" class="rounded-lg focus:ring-2 shadow-sm w-full">
                        <option value="" disabled selected>Select your Relation</option>
                        <option value="Great-grandfather" {{ old('relation') == 'Great-grandfather' ? 'selected' : '' }}>Great-grandfather</option>
                        <option value="Great-grandmother" {{ old('relation') == 'Great-grandmother' ? 'selected' : '' }}>Great-grandmother</option>
                        <option value="Great-grandson" {{ old('relation') == 'Great-grandson' ? 'selected' : '' }}>Great-grandson</option>
                        <option value="Great-granddaughter" {{ old('relation') == 'Great-granddaughter' ? 'selected' : '' }}>Great-granddaughter</option>
                        <option value="GrandFather" {{ old('relation') == 'GrandFather' ? 'selected' : '' }}>Grand Father</option>
                        <option value="GrandMother" {{ old('relation') == 'GrandMother' ? 'selected' : '' }}>Grand Mother</option>
                        <option value="Grandson" {{ old('relation') == 'Grandson' ? 'selected' : '' }}>Grandson</option>
                        <option value="Granddaughter" {{ old('relation') == 'Granddaughter' ? 'selected' : '' }}>Granddaughter</option>
                        <option value="Father" {{ old('relation') == 'Father' ? 'selected' : '' }}>Father</option>
                        <option value="Mother" {{ old('relation') == 'Mother' ? 'selected' : '' }}>Mother</option>
                        <option value="Spouse" {{ old('relation') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                        <option value="Uncle" {{ old('relation') == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                        <option value="Auntie" {{ old('relation') == 'Auntie' ? 'selected' : '' }}>Auntie</option>
                        <option value="Brother" {{ old('relation') == 'Brother' ? 'selected' : '' }}>Brother</option>
                        <option value="Sister" {{ old('relation') == 'Sister' ? 'selected' : '' }}>Sister</option>
                        <option value="Son" {{ old('relation') == 'Son' ? 'selected' : '' }}>Son</option>
                        <option value="Daughter" {{ old('relation') == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                        <option value="Nephew" {{ old('relation') == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                        <option value="Niece" {{ old('relation') == 'Niece' ? 'selected' : '' }}>Niece</option>
                        <option value="Cousin" {{ old('relation') == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                        <option value="Father-in-law" {{ old('relation') == 'Father-in-law' ? 'selected' : '' }}>Father-in-law</option>
                        <option value="Mother-in-law" {{ old('relation') == 'Mother-in-law' ? 'selected' : '' }}>Mother-in-law</option>
                        <option value="Brother-in-law" {{ old('relation') == 'Brother-in-law' ? 'selected' : '' }}>Brother-in-law</option>
                        <option value="Sister-in-law" {{ old('relation') == 'Sister-in-law' ? 'selected' : '' }}>Sister-in-law</option>
                        <option value="Son-in-law" {{ old('relation') == 'Son-in-law' ? 'selected' : '' }}>Son-in-law</option>
                        <option value="Daughter-in-law" {{ old('relation') == 'Daughter-in-law' ? 'selected' : '' }}>Daughter-in-law</option>
                        <option value="Stepfather" {{ old('relation') == 'Stepfather' ? 'selected' : '' }}>Stepfather</option>
                        <option value="Stepmother" {{ old('relation') == 'Stepmother' ? 'selected' : '' }}>Stepmother</option>
                        <option value="Stepbrother" {{ old('relation') == 'Stepbrother' ? 'selected' : '' }}>Stepbrother</option>
                        <option value="Stepsister" {{ old('relation') == 'Stepsister' ? 'selected' : '' }}>Stepsister</option>
                        <option value="Half-brother" {{ old('relation') == 'Half-brother' ? 'selected' : '' }}>Half-brother</option>
                        <option value="Half-sister" {{ old('relation') == 'Half-sister' ? 'selected' : '' }}>Half-sister</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end col-span-1 md:col-span-2">
                <button type="submit" class="px-4 py-2 text-white text-sm sm:text-base rounded bg-blue-500 hover:bg-blue-700 transition duration-300"><i class="fa-regular fa-calendar-check"></i> Set Appointment</button>  
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const appointmentDateInput = document.getElementById('appointmentdate');
            const appointmentTimeSelect = document.getElementById('appointmenttime');

            // Set minimum date for appointment
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            appointmentDateInput.min = tomorrow.toISOString().split('T')[0];

            // Prevent form reset on invalid input
            form.addEventListener('invalid', function(event) {
                event.preventDefault();
            }, true);

            // Update available time slots based on selected date
            function updateTimeSlots() {
                const selectedDate = appointmentDateInput.value;
                if (!selectedDate) return;

                fetch(`/patient/getBookedTimes?date=${selectedDate}`)
                    .then(response => response.json())
                    .then(bookedTimes => {
                        const timeOptions = appointmentTimeSelect.options;
                        
                        for (let i = 1; i < timeOptions.length; i++) {
                            const optionTime = timeOptions[i].value;
                            if (bookedTimes.includes(optionTime)) {
                                timeOptions[i].disabled = true;
                            } else {
                                timeOptions[i].disabled = false;
                            }
                        }

                        // Reset selection if the currently selected option is now disabled
                        if (appointmentTimeSelect.selectedOptions[0].disabled) {
                            appointmentTimeSelect.value = '';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            appointmentDateInput.addEventListener('change', updateTimeSlots);

            // Initial update of time slots
            updateTimeSlots();

            // Custom form validation
            form.addEventListener('submit', function(event) {
                let isValid = true;
                const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');
                
                requiredInputs.forEach(function(input) {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('border-red-500');
                    } else {
                        input.classList.remove('border-red-500');
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    alert('Please fill out all required fields.');
                }
            });
        });
    </script>

</body>
</html>

@section('title')
    Appointment
@endsection

</x-app-layout>