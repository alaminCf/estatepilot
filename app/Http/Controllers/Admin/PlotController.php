<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlotController extends Controller
{
    /**
     * Display a listing of plots.
     */
    public function index(Request $request)
    {
        $query = Plot::query();

        // Plot No filter
        if ($request->filled('plot_no')) {
            $query->where('plot_no', 'like', '%' . $request->plot_no . '%');
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('plot_no', 'like', "%{$search}%")
                  ->orWhere('block', 'like', "%{$search}%")
                  ->orWhere('road_no', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Per page
        $perPage = $request->get('per_page', 25);

        $plots = $query->latest()->paginate($perPage)->appends($request->except('page'));
        
        return view('Accounts.Admin.plots.index', compact('plots'));
    }

    /**
     * Show the form for creating a new plot.
     */
    public function create()
    {
        return view('Accounts.Admin.plots.edit');
    }

    /**
     * Store a newly created plot.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'plot_no' => 'required|string|unique:plots,plot_no',
            'size_katha' => 'required|numeric|min:0',
            'block' => 'required|string|max:50',
            'road_no' => 'required|string|max:50',
            'facing' => 'required|string|max:50',
            'agent_name' => 'nullable|string|max:255',
            'plot_category' => 'nullable|string|max:100',
            'road_width' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'booking_payment' => 'nullable|numeric|min:0',
            'installment_plan' => 'nullable|in:monthly,quarterly',
            'total_installments' => 'nullable|integer|min:1',
            'installment_payment' => 'nullable|numeric|min:0',
            'google_maps_location' => 'nullable|string',
            'nearby_facilities' => 'nullable|string',
            'status' => 'required|in:available,pending,booked,sold',
            'description' => 'nullable|string',
            'plot_map' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        // Auto-calculate remaining payment
        $validated['booking_payment'] = $validated['booking_payment'] ?? 0;
        $validated['remaining_payment'] = $validated['price'] - $validated['booking_payment'];

        // Handle file upload
        if ($request->hasFile('plot_map')) {
            $file = $request->file('plot_map');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/plots'), $filename);
            $validated['plot_map'] = 'uploads/plots/' . $filename;
        }

        Plot::create($validated);

        return redirect()->route('admin.plots.index')->with('success', 'Plot created successfully.');
    }

    /**
     * Display the specified plot.
     */
    public function show(Plot $plot)
    {
        // Load the current booking if plot is booked or sold
        $currentBooking = $plot->currentBooking;
        
        // Load all bookings for this plot with user details
        $bookings = $plot->bookings()->with(['user', 'payments'])->latest()->get();
        
        return view('Accounts.Admin.plots.show', compact('plot', 'currentBooking', 'bookings'));
    }

    /**
     * Show the form for editing the specified plot.
     */
    public function edit(Plot $plot)
    {
        if ($plot->status !== 'available') {
            return redirect()->route('admin.plots.show', $plot)->with('error', 'Only available plots can be edited. This plot is currently "' . ucfirst($plot->status) . '". Please remove all bookings first.');
        }

        return view('Accounts.Admin.plots.edit', compact('plot'));
    }

    /**
     * Update the specified plot.
     */
    public function update(Request $request, Plot $plot)
    {
        if ($plot->status !== 'available') {
            return redirect()->route('admin.plots.show', $plot)->with('error', 'Only available plots can be edited. This plot is currently "' . ucfirst($plot->status) . '". Please remove all bookings first.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'plot_no' => 'required|string|unique:plots,plot_no,' . $plot->id,
            'size_katha' => 'required|numeric|min:0',
            'block' => 'required|string|max:50',
            'road_no' => 'required|string|max:50',
            'facing' => 'required|string|max:50',
            'agent_name' => 'nullable|string|max:255',
            'plot_category' => 'nullable|string|max:100',
            'road_width' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'booking_payment' => 'nullable|numeric|min:0',
            'installment_plan' => 'nullable|in:monthly,quarterly',
            'total_installments' => 'nullable|integer|min:1',
            'installment_payment' => 'nullable|numeric|min:0',
            'google_maps_location' => 'nullable|string',
            'nearby_facilities' => 'nullable|string',
            'status' => 'required|in:available,pending,booked,sold',
            'description' => 'nullable|string',
            'plot_map' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        // Auto-calculate remaining payment
        $validated['booking_payment'] = $validated['booking_payment'] ?? 0;
        $validated['remaining_payment'] = $validated['price'] - $validated['booking_payment'];

        // Handle file upload
        if ($request->hasFile('plot_map')) {
            // Delete old file
            if ($plot->plot_map && file_exists(public_path($plot->plot_map))) {
                unlink(public_path($plot->plot_map));
            }

            $file = $request->file('plot_map');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/plots'), $filename);
            $validated['plot_map'] = 'uploads/plots/' . $filename;
        }

        $plot->update($validated);

        return redirect()->route('admin.plots.index')->with('success', 'Plot updated successfully.');
    }

    /**
     * Update the status of a plot that has no bookings.
     */
    public function updateStatus(Request $request, Plot $plot)
    {
        if ($plot->bookings()->exists()) {
            return redirect()->route('admin.plots.show', $plot)->with('error', 'Status cannot be changed manually while the plot has bookings.');
        }

        $validated = $request->validate([
            'status' => 'required|in:available,pending,booked,sold',
        ]);

        $plot->update(['status' => $validated['status']]);

        return redirect()->route('admin.plots.show', $plot)->with('success', 'Plot status updated successfully.');
    }

    /**
     * Remove the specified plot.
     */
    public function destroy(Plot $plot)
    {
        if ($plot->status !== 'available') {
            return redirect()->route('admin.plots.index')->with('error', 'Only available plots can be deleted. This plot is currently "' . ucfirst($plot->status) . '". Please remove all bookings first.');
        }

        // Check if plot has any bookings
        if ($plot->bookings()->exists()) {
            return redirect()->route('admin.plots.index')->with('error', 'This plot has bookings. Please remove all bookings first before deleting the plot.');
        }

        // Delete plot map file
        if ($plot->plot_map && file_exists(public_path($plot->plot_map))) {
            unlink(public_path($plot->plot_map));
        }

        $plot->delete();

        return redirect()->route('admin.plots.index')->with('success', 'Plot deleted successfully.');
    }
}
