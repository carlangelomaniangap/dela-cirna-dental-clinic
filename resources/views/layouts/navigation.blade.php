<nav x-data="{ open: false }" class="bg-white bg-opacity-50 shadow" style="position: sticky; top: 0; z-index: 50; backdrop-filter: blur(5px);">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">

                    @auth
                        @if(Auth::user()->usertype == 'admin')
                            <a href="{{ route('admin.dashboard') }}">
                                <img src="{{ asset('images/logo.png') }}" alt="Clinic Logo" class="h-12 w-auto" />
                            </a>
                        @elseif(Auth::user()->usertype == 'patient')
                            <a href="{{ route('patient.dashboard') }}">
                                <img src="{{ asset('images/logo.png') }}" alt="Clinic Logo" class="h-12 w-auto" />
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::check())
                        @if(Auth::user()->usertype == 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.inventory')" :active="request()->routeIs('admin.inventory')">
                                {{ __('Inventory') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.patientlist')" :active="request()->routeIs('admin.patientlist')">
                                {{ __('Patient List') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.messages')" :active="request()->routeIs('admin.messages')">
                                {{ __('Messages') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.paymentinfo')" :active="request()->routeIs('admin.paymentinfo')">
                                {{ __('Payment Information') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.calendar')" :active="request()->routeIs('admin.calendar')">
                                {{ __('Calendar') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                                {{ __('Reports') }}
                            </x-nav-link>
                        @elseif(Auth::user()->usertype == 'patient')
                            <x-nav-link :href="route('patient.dashboard')" :active="request()->routeIs('patient.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('patient.showRecord')" :active="request()->routeIs('patient.showRecord')">
                                {{ __('Patient Record') }}
                            </x-nav-link>
                            <x-nav-link :href="route('patient.appointment')" :active="request()->routeIs('patient.appointment')">
                                {{ __('Appointment') }}
                            </x-nav-link>
                            <x-nav-link :href="route('patient.messages')" :active="request()->routeIs('patient.messages')">
                                {{ __('Messages') }}
                            </x-nav-link>
                            <x-nav-link :href="route('patient.paymentinfo')" :active="request()->routeIs('patient.paymentinfo')">
                                {{ __('Payment Information') }}
                            </x-nav-link>
                            <x-nav-link :href="route('patient.calendar')" :active="request()->routeIs('patient.calendar')">
                                {{ __('Calendar') }}
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notifications Dropdown -->
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="shadow inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150 mr-4 relative">
                            <!-- Notifications Button -->
                            <i class="fas fa-bell"></i>
                            @if($unreadCount > 0)
                                <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs transform translate-x-1/2 -translate-y-2">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Notifications List -->
                        <div class="w-64 p-2">
                            <h1 class="text-lg font-semibold ml-4 mt-2">Notifications</h1>

                            <!-- Filter Buttons (Don't close the dropdown on click) -->
                            <div class="filter-buttons flex space-x-4">
                                <a href="{{ url()->current() . '?filter=all' }}" class="text-sm font-semibold px-4 py-2 rounded-lg {{ $filter == 'all' ? 'text-blue-800' : 'text-gray-400' }}">
                                    All
                                </a>

                                <a href="{{ url()->current() . '?filter=unread' }}" class="text-sm font-semibold px-4 py-2 rounded-lg {{ $filter == 'unread' ? 'text-blue-800' : 'text-gray-400' }}">
                                    Unread
                                </a>

                                <a href="{{ url()->current() . '?filter=read' }}" class="text-sm font-semibold px-4 py-2 rounded-lg {{ $filter == 'read' ? 'text-blue-800' : 'text-gray-400' }}">
                                    Read
                                </a>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                @if($notifications->isEmpty())
                                    <div class="col-span-1 shadow border rounded-lg p-4 hover:bg-gray-50 text-justify mt-2 text-xs">
                                        <p class="text-gray-600">You have no new notifications at the moment.</p>
                                    </div>
                                @else
                                    @foreach ($notifications as $notification)
                                        <div class="shadow border rounded-lg p-4 hover:bg-gray-50 text-justify mt-2 {{ $notification->read_at ? 'bg-white' : 'bg-gray-200' }}">
                                            <a href="{{ route('markAsRead', $notification->id) }}" class="flex-1 text-gray-800 hover:text-blue-600">
                                                <span class="text-xs">{{ $notification->data['message'] }}</span>
                                                <span class="text-xs text-gray-500 block mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="shadow inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div><i class="fa-solid fa-user"></i></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user mr-2 bg-gray-300 rounded-full px-2 py-1.5"></i>{{ Auth::user()->name }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt px-2"></i>{{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <!-- Notifications Dropdown -->
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="shadow inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150 mr-4 relative">
                            <!-- Notifications Button -->
                            <i class="fas fa-bell"></i>
                            @if($unreadCount > 0)
                                <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs transform translate-x-1/2 -translate-y-2">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Notifications List -->
                        <div class="w-64 p-2">
                            <h1 class="text-lg font-semibold ml-4 mt-2">Notifications</h1>

                            <!-- Filter Buttons (Don't close the dropdown on click) -->
                            <div class="filter-buttons flex space-x-4">
                                <a href="{{ url()->current() . '?filter=all' }}" class="text-sm font-semibold px-4 py-2 rounded-lg {{ $filter == 'all' ? 'text-blue-800' : 'text-gray-400' }}">
                                    All
                                </a>

                                <a href="{{ url()->current() . '?filter=unread' }}" class="text-sm font-semibold px-4 py-2 rounded-lg {{ $filter == 'unread' ? 'text-blue-800' : 'text-gray-400' }}">
                                    Unread
                                </a>

                                <a href="{{ url()->current() . '?filter=read' }}" class="text-sm font-semibold px-4 py-2 rounded-lg {{ $filter == 'read' ? 'text-blue-800' : 'text-gray-400' }}">
                                    Read
                                </a>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                @if($notifications->isEmpty())
                                    <div class="col-span-1 shadow border rounded-lg p-4 hover:bg-gray-50 text-justify mt-2 text-xs">
                                        <p class="text-gray-600">You have no new notifications at the moment.</p>
                                    </div>
                                @else
                                    @foreach ($notifications as $notification)
                                        <div class="shadow border rounded-lg p-4 hover:bg-gray-50 text-justify mt-2 {{ $notification->read_at ? 'bg-white' : 'bg-gray-200' }}">
                                            <a href="{{ route('markAsRead', $notification->id) }}" class="flex-1 text-gray-800 hover:text-blue-600">
                                                <span class="text-xs">{{ $notification->data['message'] }}</span>
                                                <span class="text-xs text-gray-500 block mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
                
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::check())
                @if(Auth::user()->usertype == 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.inventory')" :active="request()->routeIs('admin.inventory')">
                        {{ __('Inventory') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.patientlist')" :active="request()->routeIs('admin.patientlist')">
                        {{ __('Patient List') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.messages')" :active="request()->routeIs('admin.messages')">
                        {{ __('Messages') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.paymentinfo')" :active="request()->routeIs('admin.paymentinfo')">
                        {{ __('Payment Information') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.calendar')" :active="request()->routeIs('admin.calendar')">
                        {{ __('Calendar') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                        {{ __('Reports') }}
                    </x-responsive-nav-link>
                @elseif(Auth::user()->usertype == 'patient')
                    <x-responsive-nav-link :href="route('patient.dashboard')" :active="request()->routeIs('patient.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('patient.showRecord')" :active="request()->routeIs('patient.showRecord')">
                        {{ __('Patient Record') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('patient.appointment')" :active="request()->routeIs('patient.appointment')">
                        {{ __('Appointment') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('patient.messages')" :active="request()->routeIs('patient.messages')">
                        {{ __('Messages') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('patient.paymentinfo')" :active="request()->routeIs('patient.paymentinfo')">
                        {{ __('Payment Information') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('patient.calendar')" :active="request()->routeIs('patient.calendar')">
                        {{ __('Calendar') }}
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">