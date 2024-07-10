@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Properties Dashboard
</h2>
@endsection

@section('content')
<!-- Content goes here -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Properties</h3>
                @if(session('success'))
                <div id="success-banner" class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif
                <form action="{{ route('landlord.properties.create') }}" method="GET" class="inline">
                    <x-button type="submit" class="btn btn-primary mb-4">{{__('Add Property')}}</x-button>
                </form>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($properties as $property)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $property->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $property->address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $property->units }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $property->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('landlord.properties.edit', $property) }}" method="GET" class="inline">
                                        <x-button type="submit" class="btn btn-sm btn-warning">Edit</x-button>
                                    </form>
                                    <form action="{{ route('landlord.properties.destroy', $property) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection