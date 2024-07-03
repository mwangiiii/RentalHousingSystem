@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Add Property') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Add Property</h3>
                <!-- @if ($errors->any())
                <div class="mb-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif -->
                @if(session('success'))
                <div class="alert alert-success bg-green">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('landlord.properties.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="name" :value="__('Property Name')" />
                            <x-input id="name" type="text" name="name" class="mt-1 block w-full" required />
                            <x-input-error for="name" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="address" :value="__('Address')" />
                            <x-input id="address" type="text" name="address" class="mt-1 block w-full" required />
                            <x-input-error for="address" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="units" :value="__('Number of Units')" />
                            <x-input id="units" type="number" name="units" class="mt-1 block w-full" required min="1" />
                            <x-input-error for="units" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="description" :value="__('Description')" />
                            <x-textarea id="description" name="description" class="mt-1 block w-full"></x-textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Add Property') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
