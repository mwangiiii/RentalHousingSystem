@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Create Role') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('landlord.roles.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="role_name" :value="__('Role Name')" />
                            <x-input id="role_name" type="text" name="role_name" class="mt-1 block w-full" required />
                            <x-input-error for="role_name" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="property_id" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property') }}</x-label>
                            <x-select name="property_id" id="property_id" :options="$properties" fieldName="name" idField="id" class="block mt-1 w-full">
                            </x-select>
                            <x-input-error for="property_id" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Add Role') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection