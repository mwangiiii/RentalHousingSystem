<<<<<<< HEAD
@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Property Manager Dashboard') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Dashboard Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-100 p-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Properties Managed</h4>
                        <p class="text-lg">{{ $propertiesManaged->count() }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Active Leases</h4>
                        <p class="text-lg">{{ $activeLeases->count() }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Maintenance Requests</h4>
                        <p class="text-lg">{{ $maintenanceRequests->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
=======
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
>>>>>>> master
