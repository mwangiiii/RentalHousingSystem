@extends('layouts.app')

@section('header')
<div class="flex justify-between items-center mb-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 rounded-lg shadow-md">
    <h2 class="font-semibold text-2xl">
        {{ __('Notifications') }}
    </h2>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <div class="grid grid-cols-1 gap-6">
        <!-- Notification Card Example -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">New Booking Received</h3>
                <span class="text-sm text-gray-500">2 hours ago</span>
            </div>
            <p class="text-gray-700 mb-2">You have a new booking request for the property at:</p>
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-lg overflow-hidden">
                    <img src="{{ asset('images/property.jpg') }}" alt="Property Image" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="text-gray-900 font-semibold">Luxury Beach House</h4>
                    <p class="text-gray-600">Location: Malibu, California</p>
                    <p class="text-gray-600">Check-in: 15th July 2024</p>
                    <p class="text-gray-600">Guests: 2 Adults, 1 Child</p>
                    <a href="#" class="text-blue-500 hover:text-blue-700">View Booking</a>
                </div>
            </div>
        </div>

        <!-- Another Notification Example -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">New Message from Guest</h3>
                <span class="text-sm text-gray-500">Yesterday</span>
            </div>
            <p class="text-gray-700 mb-2">You have received a message from a guest regarding:</p>
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-lg overflow-hidden">
                    <img src="{{ asset('images/guest-avatar.jpg') }}" alt="Guest Avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="text-gray-900 font-semibold">John Doe</h4>
                    <p class="text-gray-600">Message: "Hi, I have a question about amenities."</p>
                    <a href="#" class="text-blue-500 hover:text-blue-700">View Message</a>
                </div>
            </div>
        </div>

        <!-- Placeholder for No Notifications -->
        <!-- <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center text-gray-500">
            <p>No new notifications.</p>
        </div> -->
    </div>
</div>
@endsection
