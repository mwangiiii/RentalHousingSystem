@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add Room') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-4">Add Room</h3>
                    <form action="{{ route('landlord.rooms.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="room_number" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Room No') }}</x-label>
                                <x-input type="text" name="room_number" id="room_number" class="mt-1 block w-full" required/>
                                <x-input-error for="room_number" class="mt-2" />
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="rent" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Rent') }}</x-label>
                                <x-input type="number" name="rent" id="rent" class="mt-1 block w-full" required/>
                                <x-input-error for="rent" class="mt-2" />
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="property_id" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Property') }}</x-label>
                                <x-select name="property_id" id="property_id" :options="$properties" fieldName="name" idField="id" class="block mt-1 w-full"></x-select>
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="description" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description') }}</x-label>
                                <x-textarea name="description" id="description" class="mt-1 block w-full" required></x-textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Add Room') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection