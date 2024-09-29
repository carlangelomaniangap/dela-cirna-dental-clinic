<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dela Cirna Dental Clinic: Record Management System with Community Forum</title>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="card">
        <img class="card-img" src="{{ asset('images/background.png') }}" alt="Card image">
        <div class="card-img-overlay">
            <thead class="antialiased">
                <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
                    @if (Auth::check())
                        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                            @if(Auth::user()->usertype == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Admin Dashboard</a>
                            @elseif(Auth::user()->usertype == 'patient')
                                <a href="{{ route('patient.dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Patient Dashboard</a>
                            @elseif(Auth::user()->usertype == 'dentistrystudent')
                                <a href="{{ route('dentistrystudent.communityforum') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Student Forum</a>
                            @endif
                        </div>
                    @else
                        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                        </div>
                    @endif
                </div>
            </thead>
    
            <tbody>
                <div class="container mt-4">
                    <div class="forum-container">
                        <div class="header">
                            <h4><i class="fa-regular fa-comments"></i> Community Forum</h4>
                        </div>
                        @foreach ($communityforums as $communityforum)
                            <div class="tweet-card">
                                <div class="tweet-header">
                                    <div>
                                        <span class="username">{{ $communityforum->user->name }}</span>
                                        <span class="timestamp">{{ $communityforum->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="tweet-content">
                                    <p>{{ $communityforum->topic }}</p>
                                </div>
                            </div>
                        @endforeach

                        <!-- pagination here -->
                        @if ($communityforums->lastPage() > 1)
                            <ul class="pagination">
                                <!-- Previous Page Link -->
                                @if ($communityforums->onFirstPage())
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link" aria-hidden="true">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $communityforums->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                                    </li>
                                @endif

                                <!-- Pagination Elements -->
                                @for ($i = 1; $i <= $communityforums->lastPage(); $i++)
                                    @if ($i == $communityforums->currentPage())
                                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $communityforums->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endfor

                                <!-- Next Page Link -->
                                @if ($communityforums->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $communityforums->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link" aria-hidden="true">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>

                
            </tbody>
        </div>
    </div>
    
    
</body>
</html>