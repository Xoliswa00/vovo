<?php

namespace App\Http\Controllers;

use App\Models\services;
use App\Http\Requests\StoreservicesRequest;
use App\Http\Requests\UpdateservicesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
  
        $services = Services::latest()->paginate(12);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'images.*' => 'image|mimes:jpg,jpeg,png',
    ]);

    $service = Services::create($validated);

 if ($request->hasFile('images')) {
    foreach ($request->file('images') as $image) {
        $path = $image->store('services', 'public');
        $service->images()->create([
            'image_path' => $path,
        ]);
    }
}

    return redirect()->route('services.index')->with('success', 'Service created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateservicesRequest $request, services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(services $services)
    {
        //
    }
    public function public()
{
        $services = Services::latest()->paginate(12);
    return view('GuestServices', compact('services'));
}

public function requestForm(Services $service)
{
    return view('services.request', compact('service'));
}

public function requestStore(Request $request, Services $service)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:20',
        'message' => 'nullable|string'
    ]);

    // Save request (could also send email notification)
    DB::table('service_requests')->insert([
        'service_id' => $service->id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'message' => $request->message,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('services.public')->with('success', 'Your request has been sent!');
}
}
