<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div class="bg-[#4b9cd3] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-10">
        <h4><i class="fa-solid fa-calendar-days"></i> Update Calendar</h4>
    </div>
    
    @if (session('success'))
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
        <form method="post" action="{{ route('admin.updatedCalendar', $calendar->id) }}" class="grid grid-cols-2 gap-6 bg-white rounded-lg shadow-md p-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <h3 class="text-3xl font-bold">Update Appointment</h3>
                    <p class="text-sm">Fill out the form to update your appointment.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="appointmentdate" class="font-semibold">Appointment Date</label>
                        <input type="date" class="rounded-lg focus:ring-2 shadow-sm w-full" id="appointmentdate" name="appointmentdate" value="{{ old('appointmentdate', $calendar->appointmentdate) }}" required>
                    </div>

                    <div>
                        <label for="appointmenttime" class="font-semibold time">Appointment Time</label>
                        <select id="appointmenttime" name="appointmenttime" class="rounded-lg focus:ring-2 shadow-sm w-full" required>
                            <option value="" disabled>Select your Time</option>
                            <option value="08:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '08:00:00' ? 'selected' : '' }}>8:00 AM - 9:00 AM</option>
                            <option value="09:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '09:00:00' ? 'selected' : '' }}>9:00 AM - 10:00 AM</option>
                            <option value="10:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '10:00:00' ? 'selected' : '' }}>10:00 AM - 11:00 AM</option>
                            <option value="11:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '11:00:00' ? 'selected' : '' }}>11:00 AM - 12:00 PM</option>
                            <option value="16:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '16:00:00' ? 'selected' : '' }}>4:00 PM - 5:00 PM</option>
                            <option value="17:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '17:00:00' ? 'selected' : '' }}>5:00 PM - 6:00 PM</option>
                            <option value="18:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '18:00:00' ? 'selected' : '' }}>6:00 PM - 7:00 PM</option>
                            <option value="19:00:00" {{ old('appointmenttime', $calendar->appointmenttime) == '19:00:00' ? 'selected' : '' }}>7:00 PM - 8:00 PM</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="concern" class="font-semibold">Concern<span class="text-gray-500">(e.g. Teeth Cleaning, Tooth Extraction, Braces etc.)</span></label>
                    <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="concern" name="concern" value="{{ old('concern', $calendar->concern) }}" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="font-semibold">Name</label>
                        <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" id="name" name="name" value="{{ old('name', $calendar->name) }}" readonly required>
                    </div>
                    <div>
                        <label for="gender" class="font-semibold">Gender</label>
                        <select id="gender" name="gender" class="rounded-lg focus:ring-2 shadow-sm w-full" readonly required>
                            <option value="" disabled selected>Select your Gender</option>
                            <option value="Male" {{ old('gender', $calendar->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $calendar->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="birthday" class="font-semibold">Birthday</label>
                        <input type="date" class="rounded-lg focus:ring-2 shadow-sm w-full" id="birthday" name="birthday" value="{{ old('birthday', $calendar->birthday) }}" readonly required>
                    </div>
                    
                    <div>
                        <label for="age" class="font-semibold">Age</label>
                        <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="age" name="age" value="{{ old('age', $calendar->age) }}" readonly required>
                    </div>
                </div>

                <div>
                    <label for="address" class="font-semibold">Address</label>
                    <textarea class="rounded-lg focus:ring-2 shadow-sm w-full" id="address" name="address" placeholder="Type here..." readonly required>{{ old('address', $calendar->address) }}</textarea>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="font-semibold">Phone No. <span class="text-gray-500">(09XXXXXXXXX)</span></label>
                        <input type="tel" class="rounded-lg focus:ring-2 shadow-sm w-full" id="phone" name="phone" value="{{ old('phone', $calendar->phone) }}" readonly required>
                    </div>
                    
                    <div>
                        <label for="email" class="font-semibold">Email</label>
                        <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full bg-gray-100" id="email" name="email" value="{{ old('email', $calendar->email) }}" readonly required>
                    </div>
                </div>
                
                <div>
                    <label for="medicalhistory" class="font-semibold">Medical History <span class="text-gray-500">(Optional)</span></label>
                    <textarea class="rounded-lg focus:ring-2 shadow-sm w-full" id="medicalhistory" name="medicalhistory" placeholder="Type here..." readonly>{{ old('medicalhistory', $calendar->medicalhistory) }}</textarea>
                </div>

                <div>
                    <div>
                        <h1 class="font-semibold text-xl pb-2">Emergency Contacts</h1>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="emergencycontactname" class="font-semibold">Name</label>
                            <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactname" name="emergencycontactname" value="{{ old('emergencycontactname', $calendar->emergencycontactname) }}" readonly required>
                        </div>

                        <div>
                            <label for="emergencycontactrelation" class="font-semibold">Relation</label>
                            <select id="emergencycontactrelation" name="emergencycontactrelation" class="rounded-lg focus:ring-2 shadow-sm w-full" readonly required>
                                <option value="" disabled selected>Select your Relation</option>
                                <option value="Father" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Father' ? 'selected' : '' }}>Father</option>
                                <option value="Mother" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Mother' ? 'selected' : '' }}>Mother</option>
                                <option value="Brother" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Brother' ? 'selected' : '' }}>Brother</option>
                                <option value="Sister" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Sister' ? 'selected' : '' }}>Sister</option>
                                <option value="Friend" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Friend' ? 'selected' : '' }}>Friend</option>
                                <option value="Others" {{ old('emergencycontactrelation', $calendar->emergencycontactrelation) == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="emergencycontactphone" class="font-semibold">Contact Number</label>
                        <input type="tel" class="rounded-lg focus:ring-2 shadow-sm w-full" id="emergencycontactphone" name="emergencycontactphone" value="{{ old('emergencycontactphone', $calendar->emergencycontactphone) }}" readonly required>
                    </div>
                </div>
                <div>
                    <div>
                        <h1 class="font-semibold text-xl pb-3">Fill out this if you're not the patient</h1>
                    </div>
                        
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="relationname" class="font-semibold">Name <span class="text-gray-500">(Optional)</span></label>
                            <input type="text" class="rounded-lg focus:ring-2 shadow-sm w-full" id="relationname" name="relationname" value="{{ old('relationname', $calendar->relationname) }}" readonly>
                        </div>

                        <div>
                            <label for="relation" class="font-semibold">Relation <span class="text-gray-500">(Optional)</span></label>
                            <select id="relation" name="relation" class="rounded-lg focus:ring-2 shadow-sm w-full" readonly>
                                <option value="" disabled selected>Select your Relation</option>
                                <option value="Father" {{ old('relation', $calendar->relation, $calendar->relation) == 'Father' ? 'selected' : '' }}>Father</option>
                                <option value="Mother" {{ old('relation', $calendar->relation) == 'Mother' ? 'selected' : '' }}>Mother</option>
                                <option value="Son" {{ old('relation', $calendar->relation) == 'Son' ? 'selected' : '' }}>Son</option>
                                <option value="Daughter" {{ old('relation', $calendar->relation) == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                <option value="Nephew" {{ old('relation', $calendar->relation) == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                                <option value="Niece" {{ old('relation', $calendar->relation) == 'Niece' ? 'selected' : '' }}>Niece</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-[#4b9cd3] text-white font-semibold py-2 px-4 rounded hover:bg-[#368cbf]">Update Appointment</button>
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

</x-app-layout>
