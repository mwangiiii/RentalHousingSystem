@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Property Dashboard') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-2xl mb-4">{{ $property->name }}</h3>

            <h4 class="text-xl mt-6 mb-2">Your Room</h4>
            <p><strong>Room Number:</strong> {{ $room->room_number }}</p>
            <p><strong>Rent Amount:</strong> Kshs {{ $room->rent }}</p>

            <h4 class="text-xl mt-6 mb-2">Lease Agreement</h4>
            <p><strong>Lease Start Date:</strong> {{ $tenantDetails->lease_start->format('M d, Y') }}</p>
            <p><strong>Lease End Date:</strong> {{ $tenantDetails->lease_end->format('M d, Y') }}</p>

            <div class="mt-4">
                <a href="{{ Storage::url($pdfPath) }}" class="bg-blue-500 text-white px-4 py-2 rounded">View Lease Agreement</a>
                <a href="{{ Storage::url($pdfPath) }}" download class="bg-green-500 text-white px-4 py-2 rounded">Download Lease Agreement</a>
            </div>

            <h4 class="text-xl mt-6 mb-2">Contact Details</h4>
            <p><strong>Landlord:</strong> {{ $landlord->name }} : <a href="tel:{{ $landlord->phone_number }}">{{ $landlord->phone_number }}</a> :  <a href="mailto:{{ $landlord->email }}">{{ $landlord->email }}</a> </p>
            <p><strong>Property Manager:</strong> {{ $propertyManager->name }} : <a href="tel:{{ $propertyManager->phone_number }}">{{ $propertyManager->phone_number }}</a> : <a href="mailto:{{ $propertyManager->email }}">{{ $propertyManager->email }}</a></p>
            <p><strong>Maintenance Worker:</strong> {{ $maintenanceWorker->name }}: {{ $maintenanceWorker->phone_number }} : <a href="mailto:{{ $maintenanceWorker->email }}">{{ $maintenanceWorker->email }}</a></p>
        </div>
    </div>
</div>
@endsection
