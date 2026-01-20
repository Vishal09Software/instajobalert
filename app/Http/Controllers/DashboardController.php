<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Occupation;
use App\Models\JobCategory;
use App\Models\Skill;
use App\Models\JobType;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalJobs = Occupation::count();
        $totalCategories = JobCategory::count();
        $totalSkills = Skill::count();
        $totalJobTypes = JobType::count();
        $totalUsers = User::count();
        
        // Get visitor count from sessions table
        // Count unique sessions (visitors) - sessions that are active within the last 24 hours
        $visitorCount = DB::table('sessions')
            ->where('last_activity', '>=', now()->subHours(24)->timestamp)
            ->whereNull('user_id') // Only count non-logged in visitors
            ->select('ip_address')
            ->distinct()
            ->count('ip_address');
        
        // Get total unique visitors (all time)
        $totalVisitors = DB::table('sessions')
            ->whereNull('user_id')
            ->select('ip_address')
            ->distinct()
            ->count('ip_address');
        
        // Get visitor statistics for chart (last 30 days)
        $visitorStats = $this->getVisitorStatistics(30);
        
        // Get recent activity data (optional - can be enhanced later)
        $recentJobs = Occupation::orderBy('created_at', 'desc')->take(5)->get();
        
        // Get statistics by category
        $jobsByCategory = JobCategory::withCount('occupations')
            ->orderByDesc('occupations_count')
            ->take(10)
            ->get();
        
        // Get visitor data for the last 7 days for detailed chart
        $weeklyVisitors = $this->getWeeklyVisitorData();
        
        return view('admin.dashboard.admin', [
            'totalJobs' => $totalJobs,
            'totalCategories' => $totalCategories,
            'totalSkills' => $totalSkills,
            'totalJobTypes' => $totalJobTypes,
            'totalUsers' => $totalUsers,
            'visitorCount' => $visitorCount,
            'totalVisitors' => $totalVisitors,
            'visitorStats' => $visitorStats,
            'weeklyVisitors' => $weeklyVisitors,
            'recentJobs' => $recentJobs,
            'jobsByCategory' => $jobsByCategory,
        ]);
    }
    
    /**
     * Get visitor statistics for chart
     */
    private function getVisitorStatistics($days = 30)
    {
        $startDate = Carbon::now()->subDays($days);
        $stats = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $startTimestamp = $date->startOfDay()->timestamp;
            $endTimestamp = $date->endOfDay()->timestamp;
            
            $visitors = DB::table('sessions')
                ->where('last_activity', '>=', $startTimestamp)
                ->where('last_activity', '<=', $endTimestamp)
                ->whereNull('user_id')
                ->select('ip_address')
                ->distinct()
                ->count('ip_address');
            
            $stats[] = [
                'date' => $date->format('M d'),
                'visitors' => $visitors,
            ];
        }
        
        return $stats;
    }
    
    /**
     * Get weekly visitor data (last 7 days)
     */
    private function getWeeklyVisitorData()
    {
        $stats = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $startTimestamp = $date->startOfDay()->timestamp;
            $endTimestamp = $date->endOfDay()->timestamp;
            
            $visitors = DB::table('sessions')
                ->where('last_activity', '>=', $startTimestamp)
                ->where('last_activity', '<=', $endTimestamp)
                ->whereNull('user_id')
                ->select('ip_address')
                ->distinct()
                ->count('ip_address');
            
            $stats[] = [
                'date' => $date->format('D, M d'),
                'visitors' => $visitors,
            ];
        }
        
        return $stats;
    }
}

