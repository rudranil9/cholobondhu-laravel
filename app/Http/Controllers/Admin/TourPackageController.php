<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourPackageController extends Controller
{
    /**
     * Display a listing of tour packages
     */
    public function index(Request $request)
    {
        $query = TourPackage::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->get('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        // Filter by status
        if ($status = $request->get('status')) {
            if ($status !== 'all') {
                $isActive = $status === 'active';
                $query->where('is_active', $isActive);
            }
        }

        // Filter by featured
        if ($featured = $request->get('featured')) {
            if ($featured !== 'all') {
                $isFeatured = $featured === 'yes';
                $query->where('is_featured', $isFeatured);
            }
        }

        $packages = $query->withCount('bookings')->latest()->paginate(12);

        // Get statistics
        $stats = [
            'total' => TourPackage::count(),
            'active' => TourPackage::where('is_active', true)->count(),
            'inactive' => TourPackage::where('is_active', false)->count(),
            'featured' => TourPackage::where('is_featured', true)->count(),
            'total_bookings' => \App\Models\Booking::count(),
        ];

        // Get categories for filter
        $categories = TourPackage::distinct()->pluck('category')->filter()->sort();

        return view('admin.tour-packages.index', compact('packages', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new tour package
     */
    public function create()
    {
        return view('admin.tour-packages.create');
    }

    /**
     * Store a newly created tour package
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'difficulty_level' => 'required|in:easy,moderate,challenging,extreme',
            'max_travelers' => 'required|integer|min:1',
            'mood_category' => 'nullable|string|max:100',
            'distance_from_city' => 'nullable|string|max:100',
            'best_season' => 'nullable|string|max:100',
            'features' => 'nullable|string',
            'highlights' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        
        // Convert comma-separated strings to arrays
        if ($request->features) {
            $data['features'] = array_map('trim', explode(',', $request->features));
        }
        
        if ($request->highlights) {
            $data['highlights'] = array_map('trim', explode(',', $request->highlights));
        }

        $package = TourPackage::create($data);

        return redirect()->route('admin.tour-packages.index')
            ->with('success', "Tour package '{$package->name}' has been created successfully.");
    }

    /**
     * Display the specified tour package
     */
    public function show(TourPackage $tourPackage)
    {
        $tourPackage->load(['bookings' => function($query) {
            $query->latest()->take(10);
        }]);

        $packageStats = [
            'total_bookings' => $tourPackage->bookings()->count(),
            'pending_bookings' => $tourPackage->bookings()->where('status', 'pending')->count(),
            'confirmed_bookings' => $tourPackage->bookings()->where('status', 'confirmed')->count(),
            'revenue' => $tourPackage->bookings()->where('status', 'confirmed')->sum('total_amount'),
        ];

        return view('admin.tour-packages.show', compact('tourPackage', 'packageStats'));
    }

    /**
     * Show the form for editing the specified tour package
     */
    public function edit(TourPackage $tourPackage)
    {
        return view('admin.tour-packages.edit', compact('tourPackage'));
    }

    /**
     * Update the specified tour package
     */
    public function update(Request $request, TourPackage $tourPackage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'difficulty_level' => 'required|in:easy,moderate,challenging,extreme',
            'max_travelers' => 'required|integer|min:1',
            'mood_category' => 'nullable|string|max:100',
            'distance_from_city' => 'nullable|string|max:100',
            'best_season' => 'nullable|string|max:100',
            'features' => 'nullable|string',
            'highlights' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        
        // Convert comma-separated strings to arrays
        if ($request->features) {
            $data['features'] = array_map('trim', explode(',', $request->features));
        }
        
        if ($request->highlights) {
            $data['highlights'] = array_map('trim', explode(',', $request->highlights));
        }

        $tourPackage->update($data);

        return redirect()->route('admin.tour-packages.index')
            ->with('success', "Tour package '{$tourPackage->name}' has been updated successfully.");
    }

    /**
     * Remove the specified tour package
     */
    public function destroy(TourPackage $tourPackage)
    {
        // Check if package has active bookings
        $activeBookings = $tourPackage->bookings()->whereIn('status', ['pending', 'confirmed', 'in_process'])->count();
        
        if ($activeBookings > 0) {
            return redirect()->back()->with('error', 
                "Cannot delete tour package '{$tourPackage->name}'. It has {$activeBookings} active booking(s).");
        }

        $packageName = $tourPackage->name;
        $tourPackage->delete();

        return redirect()->route('admin.tour-packages.index')
            ->with('success', "Tour package '{$packageName}' has been deleted successfully.");
    }

    /**
     * Toggle package status
     */
    public function toggleStatus(TourPackage $tourPackage)
    {
        $tourPackage->is_active = !$tourPackage->is_active;
        $tourPackage->save();

        $status = $tourPackage->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Tour package '{$tourPackage->name}' has been {$status}.");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(TourPackage $tourPackage)
    {
        $tourPackage->is_featured = !$tourPackage->is_featured;
        $tourPackage->save();

        $status = $tourPackage->is_featured ? 'marked as featured' : 'removed from featured';
        
        return redirect()->back()
            ->with('success', "Tour package '{$tourPackage->name}' has been {$status}.");
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,feature,unfeature,delete',
            'packages' => 'required|array|min:1',
            'packages.*' => 'exists:tour_packages,id'
        ]);

        $packages = TourPackage::whereIn('id', $request->packages);
        $count = $packages->count();

        switch ($request->action) {
            case 'activate':
                $packages->update(['is_active' => true]);
                $message = "{$count} tour packages have been activated.";
                break;
            case 'deactivate':
                $packages->update(['is_active' => false]);
                $message = "{$count} tour packages have been deactivated.";
                break;
            case 'feature':
                $packages->update(['is_featured' => true]);
                $message = "{$count} tour packages have been marked as featured.";
                break;
            case 'unfeature':
                $packages->update(['is_featured' => false]);
                $message = "{$count} tour packages have been removed from featured.";
                break;
            case 'delete':
                // Check for active bookings
                $packagesWithBookings = $packages->whereHas('bookings', function($query) {
                    $query->whereIn('status', ['pending', 'confirmed', 'in_process']);
                })->count();
                
                if ($packagesWithBookings > 0) {
                    return redirect()->back()->with('error', 
                        "{$packagesWithBookings} tour packages have active bookings and cannot be deleted.");
                }
                
                $packages->delete();
                $message = "{$count} tour packages have been deleted.";
                break;
        }

        return redirect()->route('admin.tour-packages.index')->with('success', $message);
    }
}