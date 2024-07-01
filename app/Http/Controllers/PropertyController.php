<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    //Function to display the owned properties absed on user_id
    public function index()
    {
        $properties = Property::where('user_id', Auth::id())->get();
        return view('landlord.properties.index', compact('properties'));
    }
    
    //Function to display view to create a property
    public function create(){
        return view('landlord.properties.create');
    }

    //Function to store the properties in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'units' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Property::create([
            'name' => $request->name,
            'address' => $request->address,
            'units' => $request->units,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('landlord.properties.index')->with('success', 'Property added successfully.');
    }

    //Function to display the edit blade
    public function edit(Property $property)
    {
        
        return view('landlord.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'units' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $property->update([
            'name' => $request->name,
            'address' => $request->address,
            'units' => $request->units,
            'description' => $request->description,
        ]);

        return redirect()->route('landlord.properties.index')->with('success', 'Property updated successfully.');
    }

    //Function to delete a property
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('landlord.properties.index')->with('success', 'Property deleted successfully.');
    }
}
