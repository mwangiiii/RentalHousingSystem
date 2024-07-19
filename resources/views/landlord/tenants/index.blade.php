@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{__('Tenants Dashboard')}}
</h2>
@endsection

@section('content')
<!-- Content goes here -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Tenants</h3>
                @if(session('success'))
                <div id="success-banner" class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div id="success-banner" class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif

                <form action="{{ route('landlord.tenants.create') }}" method="GET" class="inline">
                    <x-button type="submit" class="btn btn-primary mb-4">{{__('Add Tenant')}}</x-button>
                </form>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Phone Number') }}</th>
                                <!-- <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Id Number/Passport') }}</th> -->
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Property') }}</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Room') }}</th>
                                <!-- <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Lease Start') }}</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Lease End') }}</th> -->
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($tenants as $tenant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->user->phone_number }}</td>
                                <!-- <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->user->id_number }}</td> -->
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->property->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->room->room_number }}</td>
                                <!-- <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->lease_start->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->lease_end->format('Y-m-d') }}</td> -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('landlord.tenants.edit', $tenant) }}" method="GET" class="inline">
                                        <x-button type="submit" class="btn btn-sm btn-warning">{{__('Edit')}}</x-button>
                                    </form>
                                    <form action="{{ route('landlord.tenants.destroy', $tenant) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tenant?')">{{__('Delete')}}</x-danger-button>
                                    </form>
                                    @if($tenant->user->is_suspended)
                                    <form action="{{ route('landlord.tenants.checkin', $tenant) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <x-button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to check out this tenant?')">{{__('Check In')}}</x-button>
                                    </form>
                                    @else
                                    <form action="{{ route('landlord.tenants.checkout', $tenant) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <x-danger-button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to check out this tenant?')">{{__('Check Out')}}</x-danger-button>
                                    </form>
                                    @endif
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