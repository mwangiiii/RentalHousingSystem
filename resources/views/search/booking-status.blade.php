@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">House Booking Status</h2>

        <div class="mb-4">
            <h3 class="text-xl font-medium">House ID: {{ $house->id }}</h3>
            <p class="text-gray-600">Location: {{ $house->location }}</p>
        </div>

        @if ($isBooked)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">This house has been booked.</span>
            </div>

            <div class="mt-6">
                <h4 class="text-lg font-medium mb-2">Bookings:</h4>
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="py-2">Booking ID</th>
                            <th class="py-2">Move-in Date</th>
                            <th class="py-2">Lease Duration</th>
                            <th class="py-2">Number of Occupants</th>
                            <th class="py-2">Employment Status</th>
                            <th class="py-2">Contact Method</th>
                            <th class="py-2">Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="border px-4 py-2">{{ $booking->id }}</td>
                                <td class="border px-4 py-2">{{ $booking->move_in_date }}</td>
                                <td class="border px-4 py-2">{{ $booking->lease_duration }} months</td>
                                <td class="border px-4 py-2">{{ $booking->number_of_occupants }}</td>
                                <td class="border px-4 py-2">{{ $booking->employment_status }}</td>
                                <td class="border px-4 py-2">{{ $booking->contact_method }}</td>
                                <td class="border px-4 py-2">{{ $booking->message }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">This house has not been booked yet.</span>
            </div>
        @endif
    </div>
</div>
@endsection
