@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="relative h-64">
            <img src="{{ asset('makazi-hub-favicon-black.png') }}" alt="House Image" class="w-full h-full object-cover">
        </div>
        <div class="p-6">
            <h1 class="text-3xl font-semibold text-gray-900 mb-4">Edit Your Booking</h1>

            <form action="{{ route('booking.update', $booking->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="move_in_date" class="block text-lg font-semibold text-gray-900">Move-in Date</label>
                    <input type="date" name="move_in_date" id="move_in_date" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ $booking->move_in_date }}" required>
                </div>

                <div>
                    <label for="duration" class="block text-lg font-semibold text-gray-900">Duration (nights)</label>
                    <input type="number" name="duration" id="duration" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="1" max="30" value="{{ $booking->duration }}" required>
                </div>

                <div>
                    <label for="message" class="block text-lg font-semibold text-gray-900">Message (optional)</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $booking->message }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
