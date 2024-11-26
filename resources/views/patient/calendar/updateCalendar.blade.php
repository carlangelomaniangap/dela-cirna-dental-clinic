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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fa-solid fa-calendar-days"></i> Appointment Details / {{ $calendar->name }} / Update</h4>
    </div>

    <div class="p-6">
        <form method="post" action="{{ route('patient.updatedCalendar', $calendar->id) }}" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white rounded-lg shadow-md p-6">
            
            @csrf

            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-base lg:text-2xl font-bold">Patient Appointment</h3>
                    <p class="text-xs lg:text-sm">Fill out the form to schedule your appointment.</p>
                </div>
                
                <div>
                    <label for="appointmentdate" class="text-sm lg:text-base font-semibold">Appointment Date</label>
                    <input type="date" class="rounded-lg focus:ring-2 shadow-sm w-full" id="appointmentdate" name="appointmentdate" value="{{ old('appointmentdate', $calendar->appointmentdate) }}" required>
                </div>

                <div>
                    <label for="appointmenttime" class="text-sm lg:text-base font-semibold">Appointment Time</label>
                    <select id="appointmenttime" name="appointmenttime" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                        <option value="" disabled selected>Select your Time</option>
                        <option value="08:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '08:00:00' ? 'selected' : '' }}>8:00 AM - 9:00 AM</option>
                        <option value="09:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '09:00:00' ? 'selected' : '' }}>9:00 AM - 10:00 AM</option>
                        <option value="10:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '10:00:00' ? 'selected' : '' }}>10:00 AM - 11:00 AM</option>
                        <option value="11:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '11:00:00' ? 'selected' : '' }}>11:00 AM - 12:00 PM</option>
                        <option value="15:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '15:00:00' ? 'selected' : '' }}>3:00 PM - 4:00 PM</option>
                        <option value="16:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '16:00:00' ? 'selected' : '' }}>4:00 PM - 5:00 PM</option>
                        <option value="17:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '17:00:00' ? 'selected' : '' }}>5:00 PM - 6:00 PM</option>
                        <option value="18:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '18:00:00' ? 'selected' : '' }}>6:00 PM - 7:00 PM</option>
                        <option value="19:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '19:00:00' ? 'selected' : '' }}>7:00 PM - 8:00 PM</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="concern" class="text-sm lg:text-base font-semibold">Concern</label>
                    <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="concern" name="concern" value="{{ old('concern', $calendar->concern) }}" placeholder="e.g., Cleaning, Pasta, Braces" required>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="medicalhistory" class="text-sm lg:text-base font-semibold">Medical History <span class="text-gray-500">(Optional)</span></label>
                    <textarea class="rounded-lg focus:ring-2 shadow-sm w-full" id="medicalhistory" name="medicalhistory" placeholder="Type here...">{{ old('medicalhistory', $calendar->medicalhistory) }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-1 md:col-span-2">
                    <h1 class="font-semibold text-base lg:text-lg">Emergency Contacts</h1>
                </div>

                <div>
                    <label for="emergencycontactname" class="text-sm lg:text-base font-semibold">Name</label>
                    <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactname" name="emergencycontactname" value="{{ old('emergencycontactname', $calendar->emergencycontactname) }}" required>
                </div>

                <div>
                    <label for="emergencycontactrelation" class="text-sm lg:text-base font-semibold">Relation</label>
                    <select id="emergencycontactrelation" name="emergencycontactrelation" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                        <option value="" disabled selected>Select your Relation</option>
                        <option value="GrandFather" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'GrandFather' ? 'selected' : '' }}>Grand Father</option>
                        <option value="GrandMother" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'GrandMother' ? 'selected' : '' }}>Grand Mother</option>
                        <option value="Father" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Father' ? 'selected' : '' }}>Father</option>
                        <option value="Mother" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Mother' ? 'selected' : '' }}>Mother</option>
                        <option value="Spouse" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                        <option value="Uncle" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                        <option value="Auntie" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Auntie' ? 'selected' : '' }}>Auntie</option>
                        <option value="Brother" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Brother' ? 'selected' : '' }}>Brother</option>
                        <option value="Sister" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Sister' ? 'selected' : '' }}>Sister</option>
                        <option value="Son" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Son' ? 'selected' : '' }}>Son</option>
                        <option value="Daughter" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                        <option value="Nephew" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                        <option value="Niece" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Niece' ? 'selected' : '' }}>Niece</option>
                        <option value="Cousin" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="emergencycontactphone" class="text-sm lg:text-base font-semibold">Phone No.</label>
                    <input type="tel" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactphone" name="emergencycontactphone" value="{{ old('emergencycontactphone', $calendar->emergencycontactphone) }}" placeholder="e.g., 09123456789" required>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <h1 class="font-semibold text-base lg:text-lg">Fill out this if you're not the patient</h1>
                </div>

                <div>
                    <label for="relationname" class="text-sm lg:text-base font-semibold">Name <span class="text-gray-500">(Optional)</span></label>
                    <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="relationname" name="relationname" value="{{ old('relationname', $calendar->relationname) }}">
                </div>

                <div>
                    <label for="relation" class="text-sm lg:text-base font-semibold">Relation <span class="text-gray-500">(Optional)</span></label>
                    <select id="relation" name="relation" class="rounded-lg focus:ring-2 shadow-sm w-full">
                        <option value="" disabled selected>Select your Relation</option>
                        <option value="GrandFather" {{ old('relation', $calendar->relation) == 'GrandFather' ? 'selected' : '' }}>Grand Father</option>
                        <option value="GrandMother" {{ old('relation', $calendar->relation) == 'GrandMother' ? 'selected' : '' }}>Grand Mother</option>
                        <option value="Father" {{ old('relation', $calendar->relation) == 'Father' ? 'selected' : '' }}>Father</option>
                        <option value="Mother" {{ old('relation', $calendar->relation) == 'Mother' ? 'selected' : '' }}>Mother</option>
                        <option value="Spouse" {{ old('relation', $calendar->relation) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                        <option value="Uncle" {{ old('relation', $calendar->relation) == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                        <option value="Auntie" {{ old('relation', $calendar->relation) == 'Auntie' ? 'selected' : '' }}>Auntie</option>
                        <option value="Brother" {{ old('relation', $calendar->relation) == 'Brother' ? 'selected' : '' }}>Brother</option>
                        <option value="Sister" {{ old('relation', $calendar->relation) == 'Sister' ? 'selected' : '' }}>Sister</option>
                        <option value="Son" {{ old('relation', $calendar->relation) == 'Son' ? 'selected' : '' }}>Son</option>
                        <option value="Daughter" {{ old('relation', $calendar->relation) == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                        <option value="Nephew" {{ old('relation', $calendar->relation) == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                        <option value="Niece" {{ old('relation', $calendar->relation) == 'Niece' ? 'selected' : '' }}>Niece</option>
                        <option value="Cousin" {{ old('relation', $calendar->relation) == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end col-span-1 md:col-span-2">
                <button type="submit" class="px-4 py-2 text-xs lg:text-base rounded bg-blue-600 hover:bg-blue-700 text-white transition duration-300 mr-2"><i class="fa-regular fa-calendar-check"></i> Update</button>
                <a href="{{ route('patient.viewDetails', $calendar->id) }}" class="px-4 py-2 text-xs lg:text-base rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition duration-300"><i class="fa-regular fa-rectangle-xmark"></i> Cancel</a>
            </div>
        </form>
    </div>

    <!-- <script>
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
    </script> -->
    
</body>
</html>

@section('title')
    Update Appointment
@endsection

</x-app-layout>
