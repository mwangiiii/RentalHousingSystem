@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Roles Dashboard') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Roles</h3>
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
                <form action="{{ route('landlord.roles.create') }}" method="GET" class="inline">
                    <x-button type="submit" class="btn btn-primary mb-4">{{__('Add Role')}}</x-button>
                </form>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="divide-y divide-gray-200">
                            <tr>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Role Name') }}</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Property') }}</th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $role->role_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($role->property)
                                        {{ $role->property->name }}
                                    @else
                                        No Property
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('landlord.roles.edit', $role) }}" method="GET" class="inline">
                                        <x-button type="submit" class="btn btn-sm btn-warning">Edit</x-button>
                                    </form>
                                    <form action="{{ route('landlord.roles.destroy', $role) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this role?')">{{ __('Delete') }}</x-danger-button>
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