@extends ('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Add a Listing') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Create Listing</h3>
                @if(session('success'))
                <div id="success-banner" class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @elseif(session('errors'))
                <div id="error-banner" class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('errors') }}</span>
                </div>
                @endif
                <form action="{{ route('addListing.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="location" :value="__('Location')" />
                            <x-input type="text" id="location" class="block mt-1 w-full" name="location" :value="old('location')" required autofocus />
                            <x-input-error for="location" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="price" :value="__('Price')" />
                            <x-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required autofocus />
                            <x-input-error for="price" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="availability" :value="__('Availability')" />
                            <x-radio-button-group name="availability" :options="['available' => 'Available', 'unavailable' => 'Unavailable', 'booked' => 'Booked']" selected="{{ old('availability') ?? $yourModel->availability ?? '' }}" /> 
                            <x-input-error for="availability" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="phone_number" :value="__('Phone Number')" />
                            <x-input id="phone_number" type="tel" class="block mt-1 w-full" name="phone_number" :value="old('phone_number')" required autofocus />
                            <x-input-error for="phone_number" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="rules_and_regulations" :value="__('Rules And Regulations')" />
                            <x-textarea id="rules_and_regulations" class="block mt-1 w-full" name="rules_and_regulations" :value="old('rules_and_regulations')" required autofocus></x-textarea>
                            <x-input-error for="rules_and_regulations" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="amenities" :value="__('Amenities')" />
                            <x-textarea id="amenities" class="block mt-1 w-full" name="amenities" :value="old('amenities')" required autofocus></x-textarea>
                            <x-input-error for="amenities" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="category_id" :value="__('Category')" />
                            <x-select id="category_id" class="block mt-1 w-full" name="category_id" :value="old('category_id')" :options="$categories" fieldName="name" idField="id" required autofocus />
                            <x-input-error for="category_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="main_image" :value="__('Main Image')" />
                            <x-input id="main_image" class="block mt-1 w-full" name="main_image" :value="old('main_image')" type="file" required autofocus />
                            <x-input-error for="main_image" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="home_image" :value="__('Home Image')" />
                            <x-input id="home_image" class="block mt-1 w-full" name="home_image" :value="old('home_image')" type="file" required autofocus />
                            <x-input-error for="home_image" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Create Listing') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection