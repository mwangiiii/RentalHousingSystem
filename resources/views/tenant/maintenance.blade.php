@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Maintenance Dashboard') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900">Maintenance Worker Contact</h3>
            @if(session('success'))
                <div id="success-banner" class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif
            @if($maintenanceWorker)
                <p><strong>Name:</strong> {{ $maintenanceWorker->name }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $maintenanceWorker->email }}">{{ $maintenanceWorker->email }}</a></p>
                <p><strong>Phone:</strong> <a href="tel:{{ $maintenanceWorker->phone_number }}">{{ $maintenanceWorker->phone_number }}</a></p>
            @else
                <p>No maintenance worker assigned to this property.</p>
            @endif

            <!-- Maintenance Request Form -->
            <h3 class="text-lg font-medium text-gray-900 mt-6">Submit a Maintenance Request</h3>
            <form action="{{ route('tenants.maintenance.store') }}" method="POST">
                @csrf
                <div class="mt-4">
                    <x-label for="description" :value="__('Description')" />
                    <x-textarea id="description" name="description" rows="4" class="mt-1 block w-full" required autofocus></x-textarea>
                </div>
                <div class="mt-4">
                    <x-button>
                        {{ __('Submit Request') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection