<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Property;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('landlord.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('landlord.rooms.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,NULL,id,property_id,' . $request->property_id,
            'rent' => 'required|numeric',
            'description' => 'nullable|string',
            'property_id' => 'required|exists:properties,id',
        ]);

        $property = Property::find($request->property_id);
        if ($property->rooms()->count() >= $property->units) {
            return redirect()->back()->withErrors(['error' => 'Cannot add more rooms than the property units.']);
        }

        $room = Room::create($request->all());
        return redirect()->route('landlord.rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        $properties = Property::all();
        return view('landlord.rooms.edit', compact('room', 'properties'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id . ',id,property_id,' . $room->property_id,
            'rent' => 'required|numeric',
            'description' => 'required|string',
            'property_id' => 'required|exists:properties,id',
        ]);

        $room->update($request->all());

        return redirect()->route('landlord.rooms.index')->with('success', 'Room updated successfully.');
    }


    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('landlord.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
