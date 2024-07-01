@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Edit Property') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('landlord.properties.update', $property) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Property Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="name" :value="__('Property Name')" />
                            <x-input id="name" type="text" class="mt-1 block w-full" name="name" :value="old('name', $property->name)" required autofocus />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="address" :value="__('Address')" />
                            <x-input id="address" type="text" class="mt-1 block w-full" name="address" :value="old('address', $property->address)" required />
                            <x-input-error for="address" class="mt-2" />
                        </div>

                        <!-- No. of units -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="units" :value="__('Units')" />
                            <x-input id="units" type="number" class="mt-1 block w-full" name="units" :value="old('units', $property->units)" required />
                            <x-input-error for="units" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="description" :value="__('Description')" />
                            <x-textarea id="description" name="description" class="mt-1 block w-full">{{ old('description', $property->description) }}</x-textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Update Property') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
