<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Plot;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Get latest 6 available plots
        $featuredPlots = Plot::where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get unique values for filters
        $blocks = Plot::where('status', 'available')
            ->distinct()
            ->pluck('block')
            ->sort()
            ->values();

        $sizes = Plot::where('status', 'available')
            ->distinct()
            ->pluck('size_katha')
            ->sort()
            ->values();

        $facings = Plot::where('status', 'available')
            ->distinct()
            ->pluck('facing')
            ->sort()
            ->values();

        // Get all plots for map view (grouped by block)
        $allPlotsForMap = Plot::orderBy('block')->orderBy('road_no')->orderBy('plot_no')->get();

        return view('Website.home', compact('featuredPlots', 'blocks', 'sizes', 'facings', 'allPlotsForMap'));
    }
}
