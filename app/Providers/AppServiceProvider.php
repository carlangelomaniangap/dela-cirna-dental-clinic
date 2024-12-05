<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        // Share notifications with all views
        View::composer('*', function ($view) {
            if (Auth::check()) {

                // Get the filter parameter from the request, default to 'all'
                $filter = request()->get('filter', 'all');
                
                // Fetch all notifications for the authenticated user
                $allNotifications = Auth::user()->notifications;
                
                // Fetch unread notifications
                $unreadNotifications = Auth::user()->unreadNotifications;
                
                // Fetch read notifications
                $readNotifications = Auth::user()->readNotifications;

                // Set the notifications variable based on the selected filter
                if ($filter == 'unread') {
                    $notifications = $unreadNotifications;
                } elseif ($filter == 'read') {
                    $notifications = $readNotifications;
                } else {
                    $notifications = $allNotifications; // Default to all notifications
                }

                // Get the count of unread notifications
                $unreadCount = $unreadNotifications->count();

                // If the user is authenticated, pass the notifications to the view
                $view->with(['notifications' => $notifications, 'filter' => $filter, 'unreadCount' => $unreadCount]);
            }
        });
    }
}
