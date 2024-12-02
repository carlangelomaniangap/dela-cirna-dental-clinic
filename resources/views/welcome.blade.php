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

    <header class="bg-white sticky top-0 z-50 bg-opacity-80">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
            <a href="/">
                <div class="flex ml-6 text-2xl">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-14 h-14">
                </div>
            </a>
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
                    </div>
                @endif
            </div>
        </div>
    </header>

    <section class="bg-cover relative min-h-screen overflow-hidden flex items-center" style="background-image: url('images/background.png')">  
        
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
    <section class="bg-cover relative bg-gray-100 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 py-11" style="background-image: url('images/background2.png')">
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
    <footer class="bg-white text-gray-800 py-5">

        <div class="container mx-auto">
            <a href="/">
                <div class="flex justify-center items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                    <h3 class="text-2xl font-semibold">Bataan Dental</h3>
                </div>
            </a>
            
            <!-- Copyright -->
            <div class="mt-10 text-center text-sm">
                <p>&copy; 2024 <a href="/" class="hover:underline">Bataan Dental</a>. All rights reserved.</p>
            </div>
            
        </div>

    </footer>
    
    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    </script>

    <script>
        document.addEventListener('keydown', function (e) {
            // Disable F12 (DevTools)
            if (e.key === 'F12') {
                e.preventDefault();
            }
            // Disable Ctrl+Shift+I or Ctrl+Shift+C
            if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'C')) {
                e.preventDefault();
            }
            // Disable Ctrl+U (View source)
            if (e.ctrlKey && e.key === 'u') {
                e.preventDefault(); // Disable Ctrl+U
            }
        });
    </script>

    
</body>
</html>