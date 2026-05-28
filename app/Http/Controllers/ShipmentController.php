<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Vehicle;
use App\Models\Order;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with('vehicle', 'order')->latest()->paginate(15);
        return view('logistics.shipments.index', compact('shipments'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        $orders   = Order::where('type', 'logistics')->where('status', '!=', 'cancelled')->get();
        return view('logistics.shipments.create', compact('vehicles', 'orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'          => 'nullable|exists:orders,id',
            'vehicle_id'        => 'nullable|exists:vehicles,id',
            'driver_name'       => 'nullable|string|max:255',
            'driver_phone'      => 'nullable|string|max:20',
            'origin'            => 'required|string|max:255',
            'destination'       => 'required|string|max:255',
            'cargo_description' => 'nullable|string',
            'weight_kg'         => 'nullable|integer|min:0',
            'status'            => 'required|in:pending,assigned,in_transit,delivered,cancelled',
            'pickup_date'       => 'nullable|date',
            'delivery_date'     => 'nullable|date|after_or_equal:pickup_date',
            'tracking_notes'    => 'nullable|string',
        ]);

        $shipment = Shipment::create($validated);

        if ($shipment->vehicle_id && $shipment->status === 'assigned') {
            Vehicle::find($shipment->vehicle_id)?->update(['status' => 'on_job']);
        }

        return redirect()->route('shipments.show', $shipment)->with('success', 'Shipment created.');
    }

    public function show(Shipment $shipment)
    {
        $shipment->load('vehicle', 'order.items');
        return view('logistics.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $vehicles = Vehicle::whereIn('status', ['available', 'on_job'])->get();
        $orders   = Order::where('type', 'logistics')->get();
        return view('logistics.shipments.create', compact('shipment', 'vehicles', 'orders'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'order_id'          => 'nullable|exists:orders,id',
            'vehicle_id'        => 'nullable|exists:vehicles,id',
            'driver_name'       => 'nullable|string|max:255',
            'driver_phone'      => 'nullable|string|max:20',
            'origin'            => 'required|string|max:255',
            'destination'       => 'required|string|max:255',
            'cargo_description' => 'nullable|string',
            'weight_kg'         => 'nullable|integer|min:0',
            'status'            => 'required|in:pending,assigned,in_transit,delivered,cancelled',
            'pickup_date'       => 'nullable|date',
            'delivery_date'     => 'nullable|date|after_or_equal:pickup_date',
            'tracking_notes'    => 'nullable|string',
        ]);

        $oldVehicleId = $shipment->vehicle_id;
        $shipment->update($validated);

        if ($oldVehicleId && $oldVehicleId !== $shipment->vehicle_id) {
            Vehicle::find($oldVehicleId)?->update(['status' => 'available']);
        }

        if ($shipment->vehicle_id) {
            $vehicleStatus = in_array($shipment->status, ['delivered', 'cancelled']) ? 'available' : 'on_job';
            Vehicle::find($shipment->vehicle_id)?->update(['status' => $vehicleStatus]);
        }

        return redirect()->route('shipments.show', $shipment)->with('success', 'Shipment updated.');
    }

    public function destroy(Shipment $shipment)
    {
        if ($shipment->vehicle_id) {
            Vehicle::find($shipment->vehicle_id)?->update(['status' => 'available']);
        }
        $shipment->delete();
        return redirect()->route('shipments.index')->with('success', 'Shipment deleted.');
    }
}
