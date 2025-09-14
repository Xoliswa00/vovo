<?php

namespace App\Http\Controllers;

use App\Models\property_details;
use App\Http\Requests\Storeproperty_detailsRequest;
use App\Http\Requests\Updateproperty_detailsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\propert_img;



class PropertyDetailsController extends Controller
{
       public function index()
    {
        $properties = property_details::with('images')->latest()->paginate(10);
       // dd($properties);
        
        return view('property.index', compact('properties'));
    }

    public function create()
    {
        return view('property.create');
    }
public function store(Request $request)
{
    // Validate the request data
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'nullable|string|max:100',
        'country' => 'nullable|string|max:100',
        'bedrooms' => 'nullable|integer|min:0',
        'bathrooms' => 'nullable|integer|min:0',
        'garage' => 'nullable|integer|min:0',
        'parking_spaces' => 'nullable|integer|min:0',
        'property_type' => 'required|string|max:50',
        'status' => 'required|string|max:50',
        'size' => 'nullable|numeric',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Save property
    $property = property_details::create($data);

    // Handle images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $filename = $img->store('properties', 'public');

            // Save to propert_imgs table
            $property->images()->create([
                'image_path' => $filename, // 👈 use correct column name
            ]);
        }
    }

    return redirect()->route('property.index')->with('success', 'Property created successfully.');
}


    public function show($id)
{
    $property = property_details::with('images')->findOrFail($id);
    return view('property.show', compact('property'));
}



public function edit($id)
{
    $property_details = property_details::with('images')->findOrFail($id);
    return view('property.edit', compact('property_details'));
}

public function update( $request, $id)
{
    $property_details = property_details::with('images')->findOrFail($id);

    $data = $request->validated();
    $property_details->update($data);

    // Handle new images upload
   if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $filename = $img->store('properties', 'public');

            // Save to propert_imgs table
            $property_details->images()->create([
                'image_path' => $filename, // 👈 use correct column name
            ]);
        }
    }

    return redirect()->route('property.index')->with('success', 'Property updated successfully.');
}

public function destroy($id)
{
    $property_details = property_details::with('images')->findOrFail($id);

    // Delete associated images
    foreach ($property_details->images as $img) {
        if (Storage::disk('public')->exists($img->image_path)) {
            Storage::disk('public')->delete($img->image_path);
        }
        $img->delete();
    }

    $property_details->delete();

    return redirect()->route('property.index')->with('success', 'Property deleted successfully.');
}





public function guestShow($id)
{
    $property = property_details::with('images')->findOrFail($id);
    return view('guestShow', compact('property'));
}




public function listing()
{
    // Latest 1 "Premium + Featured"
          $properties = property_details::with('images')->latest()->paginate(10);
       // dd($properties);
        
        return view('property.listing', compact('properties'));

}
}

