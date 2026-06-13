<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Plot;
use Illuminate\Http\Request;

class PlotController extends Controller
{
    /**
     * Display a listing of the plots with filters.
     */
    public function index(Request $request)
    {
        $query = Plot::where('status', 'available');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('plot_no', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply filters - support both single value and array (checkbox)
        if ($request->filled('block')) {
            $blocks = is_array($request->block) ? $request->block : [$request->block];
            $query->whereIn('block', $blocks);
        }

        if ($request->filled('size')) {
            $sizes = is_array($request->size) ? $request->size : [$request->size];
            $query->whereIn('size_katha', $sizes);
        }

        if ($request->filled('facing')) {
            $facings = is_array($request->facing) ? $request->facing : [$request->facing];
            $query->whereIn('facing', $facings);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Get unique filter values for dropdowns
        $blocks = Plot::distinct()->pluck('block')->sort()->values();
        $sizes = Plot::distinct()->pluck('size_katha')->sort()->values();
        $facings = Plot::distinct()->pluck('facing')->sort()->values();

        // Apply sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'size':
                $query->orderBy('size_katha', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Paginate results (16 per page)
        $plots = $query->paginate(16);

        // Get all plots for map view (grouped by block)
        $allPlotsForMap = Plot::orderBy('block')->orderBy('plot_no')->get();

        return view('Website.plots.index', compact('plots', 'blocks', 'sizes', 'facings', 'allPlotsForMap'));
    }

    /**
     * Display the specified plot.
     */
    public function show($id)
    {
        $plot = Plot::findOrFail($id);
        $agents = \App\Models\User::where('role', 'agent')
            ->whereNotNull('commission_type')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        return view('Website.plots.show', compact('plot', 'agents'));
    }

    /**
     * Load more plots via AJAX
     */
    public function loadMore(Request $request)
    {
        $query = Plot::where('status', 'available');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('plot_no', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply filters - support both single value and array (checkbox)
        if ($request->filled('block')) {
            $blocks = is_array($request->block) ? $request->block : [$request->block];
            $query->whereIn('block', $blocks);
        }

        if ($request->filled('size')) {
            $sizes = is_array($request->size) ? $request->size : [$request->size];
            $query->whereIn('size_katha', $sizes);
        }

        if ($request->filled('facing')) {
            $facings = is_array($request->facing) ? $request->facing : [$request->facing];
            $query->whereIn('facing', $facings);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min * 100000);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max * 100000);
        }

        // Paginate results (16 per page)
        $plots = $query->orderBy('created_at', 'desc')->paginate(16);

        return response()->json([
            'plots' => view('Website.plots.partials.plot-cards', compact('plots'))->render(),
            'hasMore' => $plots->hasMorePages(),
            'nextPage' => $plots->currentPage() + 1
        ]);
    }
}
