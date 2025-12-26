<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display member dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Stats
        $upcomingEventsCount = Event::upcoming()->count();
        $totalBalance = Category::getTotalBalance();
        $formattedBalance = Category::getFormattedTotalBalance();
        $totalActiveMembers = User::members()->active()->count();

        // Upcoming events (next 5)
        $upcomingEvents = Event::upcoming()->take(5)->get();

        // Finance summary
        $categories = Category::all();

        return view('member.dashboard', compact(
            'user',
            'upcomingEventsCount',
            'totalBalance',
            'formattedBalance',
            'totalActiveMembers',
            'upcomingEvents',
            'categories'
        ));
    }
}
