<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\services;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Admin: all orders
    public function index(Request $request)
    {
        $status = $request->query('status');
        $type   = $request->query('type');

        $orders = Order::when($status, fn($q) => $q->where('status', $status))
            ->when($type, fn($q) => $q->where('type', $type))
            ->latest()->paginate(20);

        return view('orders.index', compact('orders', 'status', 'type'));
    }

    // Admin: view order
    public function show(Order $order)
    {
        $order->load('items', 'shipment.vehicle');
        return view('orders.show', compact('order'));
    }

    // Admin: update order status
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
            'notes'  => 'nullable|string',
        ]);

        $order->update($request->only('status', 'notes'));

        return redirect()->route('orders.show', $order)->with('success', 'Order status updated.');
    }

    // Guest: place product order
    public function storeProductOrder(Request $request, Product $product)
    {
        $validated = $request->validate([
            'client_name'  => 'required|string|max:255',
            'client_email' => 'required|email',
            'client_phone' => 'nullable|string|max:20',
            'quantity'     => 'required|integer|min:1|max:' . $product->stock,
            'notes'        => 'nullable|string',
        ]);

        $quantity = (int) $validated['quantity'];
        $total    = $product->price * $quantity;

        $order = Order::create([
            'client_name'  => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'] ?? null,
            'type'         => 'product',
            'status'       => 'pending',
            'total'        => $total,
            'notes'        => $validated['notes'] ?? null,
        ]);

        $order->items()->create([
            'orderable_type' => Product::class,
            'orderable_id'   => $product->id,
            'quantity'       => $quantity,
            'unit_price'     => $product->price,
        ]);

        $product->decrement('stock', $quantity);

        return redirect()->route('orders.track', $order)->with('success', 'Order placed successfully!');
    }

    // Guest: place service order
    public function storeServiceOrder(Request $request, services $service)
    {
        $validated = $request->validate([
            'client_name'  => 'required|string|max:255',
            'client_email' => 'required|email',
            'client_phone' => 'nullable|string|max:20',
            'notes'        => 'nullable|string',
        ]);

        $order = Order::create([
            'client_name'  => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'] ?? null,
            'type'         => 'service',
            'status'       => 'pending',
            'total'        => $service->price ?? 0,
            'notes'        => $validated['notes'] ?? null,
        ]);

        $order->items()->create([
            'orderable_type' => services::class,
            'orderable_id'   => $service->id,
            'quantity'       => 1,
            'unit_price'     => $service->price ?? 0,
        ]);

        return redirect()->route('orders.track', $order)->with('success', 'Service request submitted!');
    }

    // Guest: track order by order_number
    public function track(Order $order)
    {
        $order->load('items', 'shipment.vehicle');
        return view('orders.track', compact('order'));
    }
}
