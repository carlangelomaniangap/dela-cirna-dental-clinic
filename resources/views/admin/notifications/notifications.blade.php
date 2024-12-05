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
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold"><i class="fas fa-bell mr-2"></i>{{ __('Notifications') }}</h4>
    </div> -->

    <div class="p-6">
        <!-- appointment notifications -->
        <div class="notifications max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-semibold pb-2">Notifications</h1>
            <!-- Filter Buttons -->
            <div class="filter-buttons flex space-x-4 mb-6">
                <!-- All Notifications Button -->
                <a href="{{ route('admin.notifications', ['filter' => 'all']) }}" 
                class="text-sm lg:text-base font-semibold px-4 py-2 shadow-md rounded-lg mr-2 focus:outline-none {{ $filter == 'all' ? 'text-blue-800' : 'text-gray-400' }}">
                    <i class="fas fa-bell mr-2"></i> All
                </a>

                <!-- Unread Notifications Button -->
                <a href="{{ route('admin.notifications', ['filter' => 'unread']) }}" 
                class="text-sm lg:text-base font-semibold px-4 py-2 shadow-md rounded-lg mr-2 focus:outline-none {{ $filter == 'unread' ? 'text-blue-800' : 'text-gray-400' }}">
                    <i class="fas fa-inbox mr-2"></i> Unread
                </a>

                <!-- Read Notifications Button -->
                <a href="{{ route('admin.notifications', ['filter' => 'read']) }}" 
                class="text-sm lg:text-base font-semibold px-4 py-2 shadow-md rounded-lg focus:outline-none {{ $filter == 'read' ? 'text-blue-800' : 'text-gray-400' }}">
                    <i class="fas fa-check-circle mr-2"></i> Read
                </a>
            </div>

            <!-- Notifications Section -->
            <ul class="space-y-4">
                @foreach ($notifications as $notification)
                    <li class="notification-item border border-gray-200 rounded-lg p-4 shadow-sm hover:bg-gray-50 flex justify-between items-center {{ $notification->read_at ? 'bg-white' : 'bg-gray-200' }}">
                        <a href="{{ route('admin.markAsRead', $notification->id) }}" class="flex-1 text-gray-800 hover:text-blue-600">
                            <span class="notification-message font-semibold">{{ $notification->data['message'] }}</span>
                            <span class="notification-time text-sm text-gray-500 block mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                        </a>
                        <span class="status-label px-3 py-1 text-xs font-semibold rounded-full {{ $notification->read_at ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $notification->read_at ? 'Read' : 'Unread' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
        
</body>
</html>

@section('title')
    Notification
@endsection

</x-app-layout>