<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $tenantId = $user->tenant_id;

        // Leads this month (daily breakdown)
        $leadsThisMonth = Lead::where('tenant_id', $tenantId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Total leads this month
        $totalLeadsThisMonth = $leadsThisMonth->sum('count');

        // Leads last month for comparison
        $leadsLastMonth = Lead::where('tenant_id', $tenantId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        // Calculate trend
        $leadsTrend = $leadsLastMonth > 0 
            ? round((($totalLeadsThisMonth - $leadsLastMonth) / $leadsLastMonth) * 100, 1)
            : 100;

        // Most viewed vehicles (top 10)
        // Note: This requires a 'views_count' column in vehicles table or a separate views tracking table
        // For now, we'll use most recently created vehicles as a placeholder
        $mostViewedVehicles = Vehicle::where('tenant_id', $tenantId)
            ->where('status', 'published')
            ->select('id', 'brand', 'model', 'year', 'price', 'images', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Lead conversion rate
        // Assuming we have a 'status' field in leads table
        $totalLeads = Lead::where('tenant_id', $tenantId)->count();
        $convertedLeads = Lead::where('tenant_id', $tenantId)
            ->where('status', 'converted')
            ->count();
        
        $conversionRate = $totalLeads > 0 
            ? round(($convertedLeads / $totalLeads) * 100, 1)
            : 0;

        // Traffic sources (mock data - would need actual analytics integration)
        $trafficSources = [
            ['source' => 'Orgánico', 'count' => 45],
            ['source' => 'Directo', 'count' => 30],
            ['source' => 'Referido', 'count' => 15],
            ['source' => 'Social', 'count' => 10],
        ];

        return view('admin.analytics.index', compact(
            'leadsThisMonth',
            'totalLeadsThisMonth',
            'leadsTrend',
            'mostViewedVehicles',
            'conversionRate',
            'trafficSources'
        ));
    }
}
