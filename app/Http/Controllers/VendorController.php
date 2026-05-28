<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')->withCount(['services', 'products'])->latest()->paginate(15);
        return view('vendors.index', compact('vendors'));
    }

    public function create()
    {
        $users = User::all();
        return view('vendors.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'status'        => 'required|in:active,inactive,pending',
            'user_id'       => 'nullable|exists:users,id',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $filename = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('assets/img/vendors'), $filename);
            $validated['logo_path'] = 'assets/img/vendors/' . $filename;
        }
        unset($validated['logo']);

        Vendor::create($validated);

        return redirect()->route('vendors.index')->with('success', 'Vendor created.');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load('services.images', 'products.images');
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        $users = User::all();
        return view('vendors.create', compact('vendor', 'users'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'status'        => 'required|in:active,inactive,pending',
            'user_id'       => 'nullable|exists:users,id',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $filename = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('assets/img/vendors'), $filename);
            $validated['logo_path'] = 'assets/img/vendors/' . $filename;
        }
        unset($validated['logo']);

        $vendor->update($validated);

        return redirect()->route('vendors.index')->with('success', 'Vendor updated.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendors.index')->with('success', 'Vendor deleted.');
    }
}
