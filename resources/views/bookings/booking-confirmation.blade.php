@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6 text-center">
            <h1 class="text-3xl font-semibold text-gray-900 mb-4">Booking Saved</h1>
            <p class="text-lg text-gray-700 mb-6">Your booking has been successfully saved.</p>
            
            <div class="flex justify-center">
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Go to Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection
