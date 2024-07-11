<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Property;
use Illuminate\Database\QueryException;

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
        $messages = [
            'room_number.unique' => 'The room number already exists for the selected property.',
            'room_number.required' => 'The room number is required.',
            'rent.required' => 'The rent is required.',
            'rent.numeric' => 'The rent must be a numeric value.',
            'property_id.required' => 'The property ID is required.',
            'property_id.exists' => 'The selected property ID does not exist.',
        ];

        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,NULL,id,property_id,' . $request->property_id,
            'rent' => 'required|numeric',
            'description' => 'nullable|string',
            'property_id' => 'required|exists:properties,id',
        ], $messages);

        $property = Property::find($request->property_id);
        if ($property->rooms()->count() >= $property->units) {
            return redirect()->back()->withErrors(['error' => 'Cannot add more rooms than the property units.']);
        }

        try {
            Room::create($request->all());
            return redirect()->route('landlord.rooms.index')->with('success', 'Room created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('landlord.rooms.index')->withErrors(['error' => 'The room number already exists for the selected property.']);
        }
        // return redirect()->route('landlord.rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        $properties = Property::all();
        return view('landlord.rooms.edit', compact('room', 'properties'));
    }

    public function update(Request $request, Room $room)
    {
        $messages = [
            'room_number.unique' => 'The room number already exists for the selected property.',
            'room_number.required' => 'The room number is required.',
            'rent.required' => 'The rent is required.',
            'rent.numeric' => 'The rent must be a numeric value.',
            'property_id.required' => 'The property ID is required.',
            'property_id.exists' => 'The selected property ID does not exist.',
        ];

        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id . ',id,property_id,' . $room->property_id,
            'rent' => 'required|numeric',
            'description' => 'required|string',
            'property_id' => 'required|exists:properties,id',
        ], $messages);


        try {
            $room->update($request->all());
            return redirect()->route('landlord.rooms.index')->with('success', 'Room updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('landlord.rooms.index')->withErrors(['error' => 'The room number already exists for the selected property.']);
        }
        //return redirect()->route('landlord.rooms.index')->with('success', 'Room updated successfully.');
    }


    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('landlord.rooms.index')->with('success', 'Room deleted successfully.');
    }
}