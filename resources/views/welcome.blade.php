<x-guest-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.css" />
</head>
<body class="min-h-screen">

    <header class="bg-white bg-opacity-50 shadow" style="position: sticky; top: 0; z-index: 50; backdrop-filter: blur(5px);">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto">
            <a href="/">
                <div class="p-2 px-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12">
                </div>
            </a>
            <div class="p-4 flex justify-end z-10">
                @if (Auth::check())
                    <div class="z-10">
                        @if(Auth::user()->usertype == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900"><i class="fa-solid fa-user mr-2 bg-gray-300 rounded-full px-2 py-1.5"></i>{{ Auth::user()->name }}</a>
                        @elseif(Auth::user()->usertype == 'patient')
                            <a href="{{ route('patient.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900"><i class="fa-solid fa-user mr-2 bg-gray-300 rounded-full px-2 py-1.5"></i>{{ Auth::user()->name }}</a>
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
    
    <!-- Welcome -->
    <section class="py-12 mb-6">
        <!-- Background Image (with img tag) -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/background.png') }}" alt="Background Image" class="w-full h-full">
        </div>

        <!-- Content Wrapper -->
        <div class="px-6 relative z-10">
            <div class="grid grid-cols-1 gap-6 p-6">
                <div class="text-center px-8">
                    <!-- Logo -->
                    <div class="flex justify-center mb-6" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('images/logo.png') }}" alt="Dental Clinic Logo" class="w-36 h-36 lg:w-56 lg:h-56">
                    </div>
                    <!-- Main Heading -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4" data-aos="fade-up" data-aos-duration="1000">
                        Welcome to Dela Cirna Dental Clinic
                    </h1>
                    <!-- Subheading -->
                    <p class="text-base sm:text-lg lg:text-xl px-8" data-aos="fade-up" data-aos-duration="1000">
                        Your trusted partner, transforming dental care with innovative solutions. We offer a wide range of services to ensure your smile stays healthy, bright, and beautiful.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Treatment Services -->
    <section class="relative px-6 lg:px-8 py-12">
        
        <h1 class="text-center font-bold text-3xl py-12 mt-6" data-aos="fade-up" data-aos-duration="1000">Treatment Services</h1>
        
        <!-- <div class="overflow-x-auto flex gap-6 p-6"> -->

            <div class="flex justify-center gap-6 p-2" data-aos="fade-up" data-aos-duration="1000">
                <!-- First Div with 3 cards -->
                <div class="flex justify-center gap-6">
                    <!-- First Card -->
                    <div class="relative w-64 h-64 bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform transform hover:scale-105 group">
                        <img src="{{ asset('images/picture1.jpg')}}" alt="Dentures" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-0">
                        <div class="absolute inset-0 text-center text-gray-700 pt-1 transition-opacity duration-300 group-hover:opacity-0">
                            <h2 class="text-lg font-bold">Dentures</h2>
                        </div>
                        <!-- Description text that shows on hover -->
                        <div class="absolute inset-0 bg-white p-4 rounded-lg opacity-0 transform translate-y-full transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                            <h2 class="text-lg font-bold">Dentures</h2>
                            <p class="text-justify text-gray-700 text-sm">
                                Dental appliances designed to replace missing teeth and restore both functionality and aesthetics to the mouth.
                            </p>
                        </div>
                    </div>

                    <!-- Second Card -->
                    <div class="relative w-64 h-64 bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform transform hover:scale-105 group">
                        <img src="{{ asset('images/picture2.jpg')}}" alt="Dentures" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-0">
                        <div class="absolute inset-0 text-center text-gray-700 pt-1 transition-opacity duration-300 group-hover:opacity-0">
                            <h2 class="text-lg font-bold">Crown and Bridges</h2>
                        </div>
                        <div class="absolute inset-0 bg-white p-4 rounded-lg opacity-0 transform translate-y-full transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                            <h2 class="text-lg font-bold">Crown and Bridges</h2>
                            <p class="text-justify text-gray-700 text-sm">
                                Crowns restore damaged teeth, while bridges replace missing teeth by anchoring to adjacent healthy teeth.
                            </p>
                        </div>
                    </div>

                    <!-- Third Card -->
                    <div class="relative w-64 h-64 bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform transform hover:scale-105 group">
                        <img src="{{ asset('images/picture3.jpg')}}" alt="Dentures" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-0">
                        <div class="absolute inset-0 text-center text-gray-700 pt-1 transition-opacity duration-300 group-hover:opacity-0">
                            <h2 class="text-lg font-bold">Oral Prophylaxis</h2>
                        </div>
                        <div class="absolute inset-0 bg-white p-4 rounded-lg opacity-0 transform translate-y-full transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                            <h2 class="text-lg font-bold">Oral Prophylaxis</h2>
                            <p class="text-justify text-gray-700 text-sm">
                                Cleaning of teeth and gums by a dental professional, is essential for preventing cavities, gum disease, and maintaining overall oral hygiene.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-center gap-6 p-2" data-aos="fade-up" data-aos-duration="1000">
                <!-- First Div with 3 cards -->
                <div class="flex justify-center gap-6">
                    <!-- Fourth Card -->
                    <div class="relative w-64 h-64 bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform transform hover:scale-105 group">
                        <img src="{{ asset('images/picture4.jpg')}}" alt="Dentures" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-0">
                        <div class="absolute inset-0 text-center text-gray-700 pt-1 transition-opacity duration-300 group-hover:opacity-0">
                            <h2 class="text-lg font-bold">Aesthetic Restoration</h2>
                        </div>
                        <div class="absolute inset-0 bg-white p-4 rounded-lg opacity-0 transform translate-y-full transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                            <h2 class="text-lg font-bold">Aesthetic Restoration</h2>
                            <p class="text-justify text-gray-700 text-sm">
                                Improves the appearance of teeth through procedures like veneers, bonding, and whitening, achieving a natural and attractive smile.
                            </p>
                        </div>
                    </div>

                    <!-- Fifth Card -->
                    <div class="relative w-64 h-64 bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform transform hover:scale-105 group">
                        <img src="{{ asset('images/picture5.jpg')}}" alt="Dentures" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-0">
                        <div class="absolute inset-0 text-center text-gray-700 pt-1 transition-opacity duration-300 group-hover:opacity-0">
                            <h2 class="text-lg font-bold">Tooth Restoration</h2>
                        </div>
                        <div class="absolute inset-0 bg-white p-4 rounded-lg opacity-0 transform translate-y-full transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
                            <h2 class="text-lg font-bold">Tooth Restoration</h2>
                            <div class="text-justify text-gray-700 text-sm">
                                Dental procedures, such as fillings aimed at repairing damaged teeth to restore their function, appearance, and overall oral health.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        <!-- </div> -->
        
    </section>
    
    <!-- Address and Contacts -->
    <section class="p-6">
        <a href="/" class="flex justify-center items-center py-6" data-aos="fade-up" data-aos-duration="1000">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12">
            <h3 class="text-xl lg:text-3xl ml-2">Dela Cirna Dental Clinic</h3>
        </a>

        <div class="flex justify-center items-center" data-aos="fade-up" data-aos-duration="1000">
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
    </section>
    
    <!-- About us -->
    <section class="relative py-6">
        <!-- Background Image (with img tag) -->
        <div class="absolute inset-0 w-full h-full">
            <img src="{{ asset('images/background2.png') }}" alt="Background Image" class="w-full h-full object-cover object-repeat">
        </div>

        <!-- Content Wrapper -->
        <div class="px-6 relative z-10">

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-8">
                <!-- Image Section -->
                <div data-aos="fade-up" data-aos-duration="1000">
                    <img src="{{ asset('images/people.png') }}" alt="People" class="w-full h-auto">
                </div>

                <!-- Text Section -->
                <div class="flex flex-col justify-center">
                    <!-- Heading -->
                    <h2 class="text-3xl font-semibold pb-4" data-aos="fade-up" data-aos-duration="1000">About Us</h2>

                    <p class="text-justify" data-aos="fade-up" data-aos-duration="1000">We created this website to provide a supportive space where patients, students and dental professionals can connect, share experiences, and access valuable insights on oral health. Dental care can be intimidating and confusing, so our goal is to simplify it by building a community where patients can ask questions, share their stories, and get advice from experts. For professionals, it's a platform to exchange ideas, discuss industry advancements, and collaborate on cases. Ultimately, we aim to bridge the gap between dental knowledge and practice, empowering everyone to take charge of their dental health with confidence.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white pt-8 pb-4">
        <div class="text-center">
            <h3 class="text-xl lg:text-3xl" data-aos="fade-up" data-aos-duration="1000">Developers</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4" data-aos="fade-up" data-aos-duration="1000">
            <div class="flex justify-center items-center py-12 gap-6">
                <!-- Carl -->
                <div class="space-y-2">
                    <h3 class="text-base lg:text-xl">Carl Angelo Maniangap</h3>
                    <p class="text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:carlangelomaniangap@gmail.com">carlangelomaniangap@gmail.com</a>
                    </p>
                    <p class="text-gray-300">
                        <i class="fab fa-facebook-square mr-2"></i>
                        <a href="https://facebook.com/carlangelomaniangap" class="hover:text-gray-400">Facebook</a>
                    </p>
                    <p class="text-gray-300">
                        <i class="fab fa-github-square mr-2"></i>
                        <a href="https://github.com/carlangelomaniangap" class="hover:text-gray-400">GitHub</a>
                    </p>
                </div>

                <!-- Aldrin -->
                <div class="space-y-2">
                    <h3 class="text-base lg:text-xl">John Aldrin Portugal</h3>
                    <p class="text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:johnaldrinportugal@example.com">johnaldrinportugal@example.com</a>
                    </p>
                    <p class="text-gray-300">
                        <i class="fab fa-facebook-square mr-2"></i>
                        <a href="https://facebook.com/" class="hover:text-gray-400">Facebook</a>
                    </p>
                    <p class="text-gray-300">
                        <i class="fab fa-github-square mr-2"></i>
                        <a href="https://github.com/" class="hover:text-gray-400">GitHub</a>
                    </p>
                </div>
                
                <!-- Lexter -->
                <div class="space-y-2">
                    <h3 class="text-base lg:text-xl">Lexter Dave Dumas</h3>
                    <p class="text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:lexterdavedumas@example.com">lexterdavedumas@example.com</a>
                    </p>
                    <p class="text-gray-300">
                        <i class="fab fa-facebook-square mr-2"></i>
                        <a href="https://facebook.com/" class="hover:text-gray-400">Facebook</a>
                    </p>
                    <p class="text-gray-300">
                        <i class="fab fa-github-square mr-2"></i>
                        <a href="https://github.com/" class="hover:text-gray-400">GitHub</a>
                    </p>
                </div>
                
                <!-- Chris -->
                <div class="space-y-2">
                    <h3 class="text-base lg:text-xl">Chris Pangilinan</h3>
                    <p class="text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        <a style="text-decoration: none; color: inherit;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" href="mailto:chrispangilinan@example.com">chrispangilinan@example.com</a>
                    </p>
                    <p class="text-gray-300">
                        <i class="fab fa-facebook-square mr-2"></i>
                        <a href="https://facebook.com/" class="hover:text-gray-400">Facebook</a>
                    </p>
                    <p class="text-gray-300">
                        <i class="fab fa-github-square mr-2"></i>
                        <a href="https://github.com/" class="hover:text-gray-400">GitHub</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-10 text-center text-sm text-gray-400" data-aos="fade-up" data-aos-duration="1000">
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

    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.js"></script>

    <!-- Initialize AOS -->
    <script>
        AOS.init();
    </script>

</body>
</html>

@section('title')
    Bataan Dental
@endsection

</x-guest-app>