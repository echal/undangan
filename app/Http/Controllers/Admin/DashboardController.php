<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Package;
use App\Models\Template;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Summary stats
        $totalEvents    = Event::count();
        $totalUsers     = User::where('role', 'user')->count();
        $totalTemplates = Template::count();

        // Revenue: sum of package prices for all published events
        $totalRevenue = Event::where('events.is_published', true)
            ->join('packages', 'events.package_id', '=', 'packages.id')
            ->sum('packages.price');

        // Active vs expired vs draft breakdown
        $activeEvents  = Event::where('is_published', true)
            ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>', now()))
            ->count();
        $expiredEvents = Event::where('is_published', true)
            ->where('expired_at', '<=', now())
            ->count();
        $draftEvents   = Event::where('is_published', false)->count();

        // Chart: invitations created per day for last 7 days
        $weeklyData = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo);
            return [
                'label' => $date->isoFormat('ddd'),
                'date'  => $date->toDateString(),
                'count' => Event::whereDate('created_at', $date)->count(),
            ];
        });

        // Chart: revenue per month for last 6 months
        $monthlyRevenue = collect(range(5, 0))->map(function ($monthsAgo) {
            $date    = Carbon::now()->subMonths($monthsAgo);
            $revenue = Event::where('is_published', true)
                ->whereYear('events.created_at', $date->year)
                ->whereMonth('events.created_at', $date->month)
                ->join('packages', 'events.package_id', '=', 'packages.id')
                ->sum('packages.price');
            return [
                'label'   => $date->isoFormat('MMM'),
                'revenue' => (int) $revenue,
            ];
        });

        // Recent activity: last 8 events with user info
        $recentEvents = Event::with(['user', 'package'])
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'totalUsers',
            'totalTemplates',
            'totalRevenue',
            'activeEvents',
            'expiredEvents',
            'draftEvents',
            'weeklyData',
            'monthlyRevenue',
            'recentEvents',
        ));
    }
}
