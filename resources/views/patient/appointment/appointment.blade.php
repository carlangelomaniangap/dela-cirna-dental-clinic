<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div class="bg-[#4b9cd3;] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold ">
        <h4><i class="fa-regular fa-calendar-check"></i> Appointment</h4>
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
        <form method="post" action="{{ route('patient.calendar.store') }}" class="grid grid-cols-2 gap-6 bg-white rounded-lg shadow-md p-10">
            <input type="hidden" name="dentalclinic_id" value="{{ Auth::user()->dentalclinic_id }}">
        
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            
            @csrf
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <h3 class="text-3xl font-bold">Patient Appointment</h3>
                    <p class="text-sm">Fill out the form to schedule your appointment.</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="appointmentdate" class="font-semibold">Appointment Date</label>
                        <input type="date" class="rounded-lg focus:ring-2 shadow-sm w-full" id="appointmentdate" name="appointmentdate" value="{{ old('appointmentdate') }}" required>
                    </div>

                    <div>
                        <label for="appointmenttime" class="font-semibold time">Appointment Time</label>
                        <select id="appointmenttime" name="appointmenttime" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                            <option value="" disabled selected>Select your Time</option>
                            <option value="08:00:00" {{ old('appointmenttime') == '08:00:00' ? 'selected' : '' }}>8:00 AM - 9:00 AM</option>
                            <option value="09:00:00" {{ old('appointmenttime') == '09:00:00' ? 'selected' : '' }}>9:00 AM - 10:00 AM</option>
                            <option value="10:00:00" {{ old('appointmenttime') == '10:00:00' ? 'selected' : '' }}>10:00 AM - 11:00 AM</option>
                            <option value="11:00:00" {{ old('appointmenttime') == '11:00:00' ? 'selected' : '' }}>11:00 AM - 12:00 PM</option>
                            <option value="16:00:00" {{ old('appointmenttime') == '16:00:00' ? 'selected' : '' }}>4:00 PM - 5:00 PM</option>
                            <option value="17:00:00" {{ old('appointmenttime') == '17:00:00' ? 'selected' : '' }}>5:00 PM - 6:00 PM</option>
                            <option value="18:00:00" {{ old('appointmenttime') == '18:00:00' ? 'selected' : '' }}>6:00 PM - 7:00 PM</option>
                            <option value="19:00:00" {{ old('appointmenttime') == '19:00:00' ? 'selected' : '' }}>7:00 PM - 8:00 PM</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="concern" class="font-semibold">Concern</label>
                    <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="concern" name="concern" value="{{ old('concern') }}" placeholder="e.g., Cleaning, Pasta, Braces" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="font-semibold">Name</label>
                        <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" id="name" name="name" value="{{ auth()->user()->name }}" readonly required>
                    </div>
                    <div>
                        <label for="gender" class="font-semibold">Gender</label>
                        <select id="gender" name="gender" class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" disabled required>
                            <option value="" disabled selected>Select your Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' || auth()->user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' || auth()->user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        <input type="hidden" name="gender" value="{{ old('gender') ?: auth()->user()->gender }}">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="birthday" class="font-semibold">Birthday</label>
                        <input type="date" class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" id="birthday" name="birthday" value="{{ auth()->user()->birthday }}" readonly required>
                    </div>
                    
                    <div>
                        <label for="age" class="font-semibold">Age</label>
                        <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" id="age" name="age" value="{{ auth()->user()->age }}" readonly required>
                    </div>
                </div>

                <div>
                    <label for="address" class="font-semibold">Address</label>
                    <input class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" id="address" name="address" placeholder="Type here..." value="{{ auth()->user()->address }}" readonly required />
                </div>
                    
                
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="font-semibold">Phone No.</label>
                        <input type="tel" class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" id="phone" name="phone" value="{{ auth()->user()->phone }}" readonly required>
                    </div>
                    
                    <div>
                        <label for="email" class="font-semibold">Email</label>
                        <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" id="email" name="email" value="{{ auth()->user()->email }}" readonly required>
                    </div>
                </div>
                <div>
                    <label for="medicalhistory" class="font-semibold">Medical History <span class="text-gray-500">(Optional)</span></label>
                    <textarea class="rounded-lg focus:ring-2 shadow-sm w-full" id="medicalhistory" name="medicalhistory" placeholder="Type here..." value="{{ auth()->user()->medicalhistory }}"></textarea>
                </div>

                <div>
                    <div>
                        <h1 class="font-semibold text-xl pb-2">Emergency Contacts</h1>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="emergencycontactname" class="font-semibold">Name</label>
                            <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactname" name="emergencycontactname" value="{{ old('emergencycontactname') }}" required>
                        </div>

                        <div>
                            <label for="emergencycontactrelation" class="font-semibold">Relation</label>
                            <select id="emergencycontactrelation" name="emergencycontactrelation" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                                <option value="" disabled selected>Select your Relation</option>
                                <option value="Father" {{ old('emergencycontactrelation') == 'Father' ? 'selected' : '' }}>Father</option>
                                <option value="Mother" {{ old('emergencycontactrelation') == 'Mother' ? 'selected' : '' }}>Mother</option>
                                <option value="Son" {{ old('emergencycontactrelation') == 'Son' ? 'selected' : '' }}>Son</option>
                                <option value="Daughter" {{ old('emergencycontactrelation') == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                <option value="Nephew" {{ old('emergencycontactrelation') == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                                <option value="Niece" {{ old('emergencycontactrelation') == 'Niece' ? 'selected' : '' }}>Niece</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="emergencycontactphone" class="font-semibold">Phone No.</label>
                    <input type="tel" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactphone" name="emergencycontactphone" value="{{ old('emergencycontactphone') }}" placeholder="e.g., 09123456789" required>
                </div>
                    
                <div>
                    <div>
                        <h1 class="font-semibold text-xl pb-3">Fill out this if you're not the patient</h1>
                    </div>
                        
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="relationname" class="font-semibold">Name <span class="text-gray-500">(Optional)</span></label>
                            <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="relationname" name="relationname" value="{{ old('relationname') }}">
                        </div>

                        <div>
                            <label for="relation" class="font-semibold">Relation <span class="text-gray-500">(Optional)</span></label>
                            <select id="relation" name="relation" class="rounded-lg focus:ring-2 shadow-sm w-full">
                                <option value="" disabled selected>Select your Relation</option>
                                <option value="Father" {{ old('relation') == 'Father' ? 'selected' : '' }}>Father</option>
                                <option value="Mother" {{ old('relation') == 'Mother' ? 'selected' : '' }}>Mother</option>
                                <option value="Son" {{ old('relation') == 'Son' ? 'selected' : '' }}>Son</option>
                                <option value="Daughter" {{ old('relation') == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                <option value="Nephew" {{ old('relation') == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                                <option value="Niece" {{ old('relation') == 'Niece' ? 'selected' : '' }}>Niece</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-regular fa-calendar-check"></i> Set Appointment</button>  
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const birthdayInput = document.getElementById('birthday');
            const ageInput = document.getElementById('age');
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

            // Calculate age based on birthday
            function calculateAge(birthDate) {
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                return age;
            }

            birthdayInput.addEventListener('change', function() {
                const birthDate = new Date(this.value);
                ageInput.value = calculateAge(birthDate);
            });

            // Trigger age calculation on page load if birthday is already set
            if (birthdayInput.value) {
                birthdayInput.dispatchEvent(new Event('change'));
            }

            // Update available time slots based on selected date
            function updateTimeSlots() {
                const selectedDate = new Date(appointmentDateInput.value);
                const currentDate = new Date();
                const currentTime = currentDate.getHours() * 60 + currentDate.getMinutes();

                const timeOptions = appointmentTimeSelect.options;
                
                for (let i = 1; i < timeOptions.length; i++) {
                    const [hours, minutes] = timeOptions[i].value.split(':');
                    const optionTime = parseInt(hours) * 60 + parseInt(minutes);

                    if (selectedDate.toDateString() === currentDate.toDateString() && optionTime <= currentTime) {
                        timeOptions[i].disabled = true;
                    } else {
                        timeOptions[i].disabled = false;
                    }
                }

                // Reset selection if the currently selected option is now disabled
                if (appointmentTimeSelect.selectedOptions[0].disabled) {
                    appointmentTimeSelect.value = '';
                }
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