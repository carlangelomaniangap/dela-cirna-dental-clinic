<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bataan Dental</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen">

    <header class="bg-white border-gray-200 border-b">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
            <div class="flex ml-6 text-2xl">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-14 h-14">
            </div>
            <div class="p-4 flex justify-end z-10">
                @if (Auth::check())
                    <div class="z-10">
                        @if(Auth::user()->usertype == 'superadmin')
                            <a href="{{ route('superadmin.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Super Admin Dashboard</a>
                        @elseif(Auth::user()->usertype == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Admin Dashboard</a>
                        @elseif(Auth::user()->usertype == 'patient')
                            <a href="{{ route('patient.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Patient Dashboard</a>
                        @elseif(Auth::user()->usertype == 'dentistrystudent')
                            <a href="{{ route('dentistrystudent.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dentistry Student Dashboard</a>
                        @endif
                    </div>
                @else
                    <div class="z-10">
                        <a href="{{ route('login') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Register</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </header>

    <section id="createclinic" class="bg-cover relative min-h-screen overflow-hidden flex items-center" style="background-image: url('images/background.png')">  
        
        <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6 p-5">

            <div class="p-5 z-10">
                <h1 class="text-4x1 font-bold leading-tight text-4xl md:text-4xl xl:text-6xl mb-3">WELCOME TO BATAAN DENTAL</h1>
                <p class="text-justify">Your trusted platform, transforming dental clinics worldwide with innovative digital solutions. We offer a wide range of professional services to ensure every patient achieves a healthy, beautiful smile.</p>
            </div>

            <div class="bg-white rounded-lg p-5 shadow-lg flex flex-col justify-center bg-opacity-50 z-10">
                <div class="flex justify-center items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-36 h-36 lg:w-56 lg:h-56">
                </div>
            </div>

            
        </div>

    </section>
    
    <!-- About us -->
    <section id="about" class="bg-cover relative bg-gray-100 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 py-11" style="background-image: url('images/background2.png')">
        <div class="flex flex-col md:flex-row lg:-mx-8">
            <div class="w-full lg:w-1/2 lg:px-8">
                <img class="" src="{{ asset('images/people.png')}}">
            </div>
            <div class="w-full lg:w-1/2 lg:p-14">
                <h2 class="text-3xl leading-tight font-bold mt-4">About Us</h2>
                <p class="text-justify mt-2 leading-relaxed">We created this website to provide a supportive space where patients, 
                    students and dental professionals can connect, share experiences, and access valuable insights on oral health. 
                    Dental care can be intimidating and confusing, so our goal is to simplify it by building a community where patients can ask questions, 
                    share their stories, and get advice from experts. For professionals, it's a platform to exchange ideas, discuss industry advancements, 
                    and collaborate on cases. Ultimately, we aim to bridge the gap between dental knowledge and practice, 
                    empowering everyone to take charge of their dental health with confidence.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-10">

        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            
                <!-- Clinic Info -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Bataan Dental</h3>
                    <div class="flex items-center space-x-4"> <!-- Flexbox container to align img and p side by side -->
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="bg-white rounded-lg p-2 h-16 w-auto">
                        <p class="text-justify text-sm">
                            Connecting you to trusted dental clinics and a vibrant community forum for all your dental health needs and questions.
                        </p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                    <ul class="text-sm">
                        <li><a href="#createclinic" class="hover:underline">Create Clinic</a></li>
                        <li><a href="#communityforum" class="hover:underline">Community Forum</a></li>
                        <li><a href="#about" class="hover:underline">About Us</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                    <ul class="text-sm">
                        <li><span class="font-bold">Email:</span> <a href="mailto:info@bataandental.com" class="hover:underline">info@bataandental.com</a></li>
                    </ul>
                </div>

            </div>
            
            <!-- Copyright -->
            <div class="mt-10 text-center text-sm text-gray-400">
                <p>&copy; 2024 Bataan Dental. All rights reserved.</p>
            </div>
            
        </div>

    </footer>
    
</body>
</html>