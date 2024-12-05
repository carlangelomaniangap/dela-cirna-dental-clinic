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

    <header class="bg-white sticky top-0 z-50 bg-opacity-50" style="backdrop-filter: blur(5px);">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
            <a href="/">
                <div class="flex ml-6 text-2xl">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-14 h-14">
                </div>
            </a>
            <div class="p-4 flex justify-end z-10">
                @if (Auth::check())
                    <div class="z-10">
                        @if(Auth::user()->usertype == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"><i class="fa-solid fa-user mr-2 bg-gray-300 rounded-full px-2 py-1.5"></i>{{ Auth::user()->name }}</a>
                        @elseif(Auth::user()->usertype == 'patient')
                            <a href="{{ route('patient.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"><i class="fa-solid fa-user mr-2 bg-gray-300 rounded-full px-2 py-1.5"></i>{{ Auth::user()->name }}</a>
                        @endif
                    </div>
                @else
                    <div class="z-10">
                        <a href="{{ route('login') }}" class="text-gray-900 bg-white shadow focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Log in</a>
                    </div>
                @endif
            </div>
        </div>
    </header>

    <section class="bg-cover relative min-h-screen overflow-hidden flex items-center" style="background-image: url('images/background.png')">  
        <div class="grid grid-cols-1 w-full gap-6 p-5">
                <div class="flex justify-center items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-36 h-36 lg:w-56 lg:h-56">
                </div>
            <div class="px-12 text-center">
                <h1 class="text-4x1 font-bold leading-tight text-4xl md:text-4xl xl:text-6xl mb-3">WELCOME TO BATAAN DENTAL</h1>
                <p>Your trusted platform, transforming dental clinics worldwide with innovative digital solutions. We offer a wide range of professional services to ensure every patient achieves a healthy, beautiful smile.</p>
            </div>
        </div>
    </section>
    
    <!-- About us -->
    <section class="bg-cover relative bg-gray-100 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 py-11" style="background-image: url('images/background2.png')">
        <h2 class="text-center text-xl lg:text-3xl mt-4">About</h2>
        <div class="flex flex-col md:flex-row lg:-mx-8">
            <div class="w-full lg:w-1/2 lg:px-8">
                <img class="" src="{{ asset('images/people.png')}}">
            </div>
            <div class="w-full lg:w-1/2 lg:p-14">
                
                <p class="text-justify mt-2">We created this website to provide a supportive space where patients, 
                    students and dental professionals can connect, share experiences, and access valuable insights on oral health. 
                    Dental care can be intimidating and confusing, so our goal is to simplify it by building a community where patients can ask questions, 
                    share their stories, and get advice from experts. For professionals, it's a platform to exchange ideas, discuss industry advancements, 
                    and collaborate on cases. Ultimately, we aim to bridge the gap between dental knowledge and practice, 
                    empowering everyone to take charge of their dental health with confidence.</p>
            </div>
        </div>
    </section>

    <div class="p-6">
        <a href="/" class="flex justify-center items-center py-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12">
            <h3 class="text-xl lg:text-3xl ml-2">Dela Cirna Dental Clinic</h3>
        </a>

        <div class="flex justify-center items-center">
            <div class="grid grid-cols-1 md:grid-cols-3 py-12 gap-6">

                <!-- Our Address -->
                <div class="px-6">
                    <h1 class="text-xl mb-2">Our Address</h1>
                    <div class="flex items-center">
                        <span class="text-gray-500">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <span class="text-gray-500 ml-2">
                            <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="https://www.google.com/maps/place/DELA+CIRNA+DENTAL+CLINIC/@14.8016018,120.5345722,15z/data=!4m6!3m5!1s0x339642874700ea83:0x941f690e07dccc40!8m2!3d14.8016018!4d120.5345722!16s%2Fg%2F11ksgtr_8y?entry=ttu&g_ep=EgoyMDI0MTIwMi4wIKXMDSoASAFQAw%3D%3D">Old National Road, Mulawin, Orani, Bataan</a>
                            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23584.0607664727!2d120.5345722!3d14.8016018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339642874700ea83%3A0x941f690e07dccc40!2sDELA+CIRNA+DENTAL+CLINIC!5e0!3m2!1sen!2sph!4v1630919151193!5m2!1sen!2sph" width="200" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
                        </span>
                    </div>
                </div>

                <!-- Opening Hours -->
                <div class="px-6">
                    <h1 class="text-xl mb-2">Opening Hours</h1>
                    <div class="flex items-center">
                        <span class="text-gray-500">
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <span class="text-gray-500 ml-2">
                            <p>Monday - Sunday</p>
                            <p>Morning: 8:00 AM - 12:00 PM</p>
                            <p>Afternoon: 3:00 PM - 8:00 PM</p>
                        </span>
                    </div>
                </div>

                <!-- Contacts -->
                <div class="px-6">
                    <h1 class="text-xl mb-2">Contacts</h1>
                    
                    <span class="text-gray-500">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <span class="text-gray-500 ml-2"><a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="tel:+639486593662">+63 948 6593 662</a></p>

                    <span class="text-gray-500">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <span class="text-gray-500 ml-2"><a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:admin@bataandental.com">admin@bataandental.com</a></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-12 pb-6">
        <div class="text-center">
            <h3 class="text-xl lg:text-3xl">Developers</h3>
        </div>
        
        <div class="flex justify-center items-center">
            <div class="grid grid-cos-1 md:grid-cols-4 py-12 gap-6">
            
                <!-- Carl -->
                <div class="space-y-4">
                    <h3 class="text-base lg:text-xl">Carl Angelo Maniangap</h3>
                    <p class="flex items-center text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:carlangelomaniangap@gmail.com">carlangelomaniangap@gmail.com</a>
                    </p>
                    <p class="flex items-center text-gray-300">
                        <i class="fab fa-facebook-square mr-2"></i>
                        <a href="https://facebook.com/carlangelomaniangap" class="hover:text-gray-400">Facebook</a>
                    </p>
                    <p class="flex items-center text-gray-300">
                        <i class="fab fa-github-square mr-2"></i>
                        <a href="https://github.com/carlangelomaniangap" class="hover:text-gray-400">GitHub</a>
                    </p>
                </div>

                <!-- Aldrin -->
                <div class="space-y-4">
                    <h3 class="text-base lg:text-xl">John Aldrin Portugal</h3>
                    <p class="flex items-center text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:johnaldrinportugal@example.com">johnaldrinportugal@example.com</a>
                    </p>
                    <p class="flex items-center text-gray-300">
                        <i class="fab fa-facebook-square mr-2"></i>
                        <a href="https://facebook.com/" class="hover:text-gray-400">Facebook</a>
                    </p>
                    <p class="flex items-center text-gray-300">
                        <i class="fab fa-github-square mr-2"></i>
                        <a href="https://github.com/" class="hover:text-gray-400">GitHub</a>
                    </p>
                </div>
                
                <!-- Lexter -->
                <div class="space-y-4">
                    <h3 class="text-base lg:text-xl">Lexter Dave Dumas</h3>
                    <p class="flex items-center text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:lexterdavedumas@example.com">lexterdavedumas@example.com</a>
                    </p>
                    <p class="flex items-center text-gray-300">
                        <i class="fab fa-facebook-square mr-2"></i>
                        <a href="https://facebook.com/" class="hover:text-gray-400">Facebook</a>
                    </p>
                    <p class="flex items-center text-gray-300">
                        <i class="fab fa-github-square mr-2"></i>
                        <a href="https://github.com/" class="hover:text-gray-400">GitHub</a>
                    </p>
                </div>
                
                <!-- Chris -->
                <div class="space-y-4">
                    <h3 class="text-base lg:text-xl">Chris Pangilinan</h3>
                    <p class="flex items-center text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:chrispangilinan@example.com">chrispangilinan@example.com</a>
                    </p>
                    <p class="flex items-center text-gray-300">
                        <i class="fab fa-facebook-square mr-2"></i>
                        <a href="https://facebook.com/" class="hover:text-gray-400">Facebook</a>
                    </p>
                    <p class="flex items-center text-gray-300">
                        <i class="fab fa-github-square mr-2"></i>
                        <a href="https://github.com/" class="hover:text-gray-400">GitHub</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-10 text-center text-sm text-gray-400">
            <p>&copy; 2024 <a href="/" class="hover:underline">Bataan Dental</a>. All rights reserved.</p>
        </div>
    </footer>
    
    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
        
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