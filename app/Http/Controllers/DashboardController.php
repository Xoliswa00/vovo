<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipment;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\Product;
use App\Models\Project;
use App\Models\Vehicle;
use App\Models\Vendor;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // The dashboard shows platform-wide business metrics (all orders,
        // all shipments, etc.) — only admins should see it. Vendors are
        // sent to their own catalog instead of a scoped analytics view,
        // since that doesn't exist yet.
        if (! $request->user()->isAdmin()) {
            return $request->user()->isVendor()
                ? redirect()->route('products.index')
                : redirect()->route('welcome');
        }

        $stats = [
            'pending_orders'     => Order::where('status', 'pending')->count(),
            'active_shipments'   => Shipment::whereIn('status', ['assigned', 'in_transit'])->count(),
            'pending_quotes'     => QuoteRequest::where('status', 'pending')->count(),
            'total_services'     => Service::count(),
            'total_products'     => Product::count(),
            'available_vehicles' => Vehicle::where('status', 'available')->count(),
        ];

        // Orders by status (donut)
        $orderStatuses = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'];
        $orderCounts   = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')->pluck('total', 'status');
        $ordersByStatus = array_map(fn($s) => (int) ($orderCounts[$s] ?? 0), $orderStatuses);

        // Shipments by status (bar)
        $shipmentStatuses = ['pending', 'assigned', 'in_transit', 'delivered', 'cancelled'];
        $shipmentCounts   = Shipment::selectRaw('status, count(*) as total')
            ->groupBy('status')->pluck('total', 'status');
        $shipmentsByStatus = array_map(fn($s) => (int) ($shipmentCounts[$s] ?? 0), $shipmentStatuses);

        // Orders last 14 days (line)
        $days = collect(range(13, 0))->map(fn($d) => Carbon::today()->subDays($d));
        $dailyOrders = Order::whereBetween('created_at', [Carbon::today()->subDays(13)->startOfDay(), Carbon::now()])
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')->pluck('total', 'date');

        $chartData = [
            'ordersByStatus'    => $ordersByStatus,
            'shipmentsByStatus' => $shipmentsByStatus,
            'dailyLabels'       => $days->map(fn($d) => $d->format('d M'))->values()->toArray(),
            'dailyCounts'       => $days->map(fn($d) => (int) ($dailyOrders[$d->toDateString()] ?? 0))->values()->toArray(),
        ];

        $recentOrders    = Order::latest()->take(5)->get();
        $recentShipments = Shipment::with('vehicle')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'chartData', 'recentOrders', 'recentShipments'));
    }

    public function welcome()
    {
        $featuredProducts = config('features.marketplace')
            ? Product::where('status', 'active')->with('images', 'category')
                ->withCount('reviews')->withAvg('reviews as reviews_avg_rating', 'rating')
                ->latest()->take(8)->get()
            : collect();

        // Guarded so the home page keeps rendering during the window between
        // this code deploying and `php artisan migrate` running on a host
        // (the doc root is a separate copy synced by a hook, so the two
        // steps aren't atomic). A missing table just hides the section.
        $featuredProjects = rescue(fn () => Project::published()
            ->where('is_featured', true)
            ->with('images')
            ->ordered()
            ->take(3)
            ->get(), collect(), report: false);

        $vendorCount = Vendor::where('status', 'active')->count();
        $avgRating = round(Review::avg('rating') ?? 0, 1);

        return view('welcome', compact('featuredProducts', 'featuredProjects', 'vendorCount', 'avgRating'));
    }
}
