@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="relative h-64">
            <img src="{{ asset('makazi-hub-favicon-black.png') }}" alt="House Image" class="w-full h-full object-cover">
        </div>
        <div class="p-6">
            <h1 class="text-3xl font-semibold text-gray-900 mb-4">Book Your Stay</h1>
            <p class="text-lg text-gray-700 mb-6">Please fill in the details below to book this house.</p>

            <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="house_id" value="{{ $house->id }}">

                <div>
                    <label for="move_in_date" class="block text-lg font-semibold text-gray-900">Move-in Date</label>
                    <input type="date" name="move_in_date" id="move_in_date" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <div>
                    <label for="duration" class="block text-lg font-semibold text-gray-900">Duration (nights)</label>
                    <input type="number" name="duration" id="duration" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="1" max="30" required>
                </div>

                <div>
                    <label for="category" class="block text-lg font-semibold text-gray-900">Category</label>
                    <select name="category" id="category" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="Apartment">Apartment</option>
                        <option value="Own Compound">Own Compound</option>
                        <option value="Gated Community Spaces">Gated Community Spaces</option>
                        <option value="Townhouses">Townhouses</option>
                        <option value="Commercial Properties">Commercial Properties</option>
                        <option value="Short-Term Rentals">Short-Term Rentals</option>
                        <option value="Luxury Villas">Luxury Villas</option>
                        <option value="Property Management Services">Property Management Services</option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-lg font-semibold text-gray-900">Message (optional)</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Book Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
