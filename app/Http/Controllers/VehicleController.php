<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(15);
        return view('logistics.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('logistics.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'registration_plate' => 'required|string|max:50|unique:vehicles',
            'type'               => 'required|in:truck,van,motorcycle,flatbed,other',
            'make'               => 'nullable|string|max:100',
            'model'              => 'nullable|string|max:100',
            'year'               => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'capacity_kg'        => 'nullable|integer|min:0',
            'status'             => 'required|in:available,on_job,maintenance',
            'notes'              => 'nullable|string',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle added to fleet.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('shipments.order');
        return view('logistics.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('logistics.vehicles.create', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'registration_plate' => 'required|string|max:50|unique:vehicles,registration_plate,' . $vehicle->id,
            'type'               => 'required|in:truck,van,motorcycle,flatbed,other',
            'make'               => 'nullable|string|max:100',
            'model'              => 'nullable|string|max:100',
            'year'               => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'capacity_kg'        => 'nullable|integer|min:0',
            'status'             => 'required|in:available,on_job,maintenance',
            'notes'              => 'nullable|string',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle removed.');
    }
}
