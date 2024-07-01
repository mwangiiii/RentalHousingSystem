<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Property;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('property')->get();
        return view('landlord.roles.index', compact('roles'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('landlord.roles.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'property_id' => 'required|exists:properties,id',
        ]);

        Role::create($request->all());

        return redirect()->route('landlord.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $properties = Property::all();
        return view('landlord.roles.edit', compact('role', 'properties'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'property_id' => 'required|exists:properties,id',
        ]);

        $role->update($request->all());

        return redirect()->route('landlord.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('landlord.roles.index')->with('success', 'Role deleted successfully.');
    }
    
}
