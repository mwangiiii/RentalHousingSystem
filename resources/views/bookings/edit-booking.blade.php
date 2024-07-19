@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-semibold text-gray-900 mb-4">Edit Your Booking</h1>
            <p class="text-lg text-gray-700 mb-6">Update the details below to change your booking.</p>

            <form action="{{ route('booking.update', $booking->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="move_in_date" class="block text-lg font-semibold text-gray-900">Move-in Date</label>
                    <input type="date" name="move_in_date" id="move_in_date" value="{{ $booking->move_in_date }}" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <div>
                    <label for="lease_duration" class="block text-lg font-semibold text-gray-900">Lease Duration (months)</label>
                    <input type="number" name="lease_duration" id="lease_duration" value="{{ $booking->lease_duration }}" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="1" required>
                </div>

                <div>
                    <label for="number_of_occupants" class="block text-lg font-semibold text-gray-900">Number of Occupants</label>
                    <input type="number" name="number_of_occupants" id="number_of_occupants" value="{{ $booking->number_of_occupants }}" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="1" required>
                </div>

                <div>
                    <label for="employment_status" class="block text-lg font-semibold text-gray-900">Employment Status</label>
                    <select name="employment_status" id="employment_status" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="" disabled>Select your employment status</option>
                        <option value="Employed" {{ $booking->employment_status == 'Employed' ? 'selected' : '' }}>Employed</option>
                        <option value="Self-Employed" {{ $booking->employment_status == 'Self-Employed' ? 'selected' : '' }}>Self-Employed</option>
                        <option value="Unemployed" {{ $booking->employment_status == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                        <option value="Student" {{ $booking->employment_status == 'Student' ? 'selected' : '' }}>Student</option>
                    </select>
                </div>

                <div>
                    <label for="contact_method" class="block text-lg font-semibold text-gray-900">Preferred Contact Method</label>
                    <select name="contact_method" id="contact_method" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="" disabled>Select a contact method</option>
                        <option value="Email" {{ $booking->contact_method == 'Email' ? 'selected' : '' }}>Email</option>
                        <option value="Phone" {{ $booking->contact_method == 'Phone' ? 'selected' : '' }}>Phone</option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-lg font-semibold text-gray-900">Message (optional)</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $booking->message }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('move_in_date').setAttribute('min', today);
    });
</script>
@endsection
