<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipment;
use App\Models\QuoteRequest;
use App\Models\services;
use App\Models\Product;
use App\Models\Vehicle;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_orders'     => Order::where('status', 'pending')->count(),
            'active_shipments'   => Shipment::whereIn('status', ['assigned', 'in_transit'])->count(),
            'pending_quotes'     => QuoteRequest::where('status', 'pending')->count(),
            'total_services'     => services::count(),
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
        $featuredServices = services::where('status', true)->with('images', 'category')->latest()->take(6)->get();
        $featuredProducts = Product::where('status', 'active')->with('images', 'category')->latest()->take(8)->get();

        return view('welcome', compact('featuredServices', 'featuredProducts'));
    }
}
