@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Makazi Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-8 bg-white rounded-lg shadow-lg">
        <div class="header text-center mb-8">
            <img class="mx-auto h-12 mb-4" src="{{ asset('makazi-hub-favicon-black.png') }}" alt="Makazi Hub Logo">
            <h1 class="text-3xl font-bold text-gray-900">My Bookings</h1>
        </div>
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">House Location</th>
                    <th class="py-3 px-4 text-left">Move-in Date</th>
                    <th class="py-3 px-4 text-left">Lease Duration (months)</th>
                    <th class="py-3 px-4 text-left">Number of Occupants</th>
                    <th class="py-3 px-4 text-left">Employment Status</th>
                    <th class="py-3 px-4 text-left">Contact Method</th>
                    <th class="py-3 px-4 text-left">Message</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($bookings as $booking)
                <tr class="border-b border-gray-200">
                    <td class="py-3 px-4">{{ $booking->house->location }}</td>
                    <td class="py-3 px-4">{{ $booking->move_in_date }}</td>
                    <td class="py-3 px-4">{{ $booking->lease_duration }}</td>
                    <td class="py-3 px-4">{{ $booking->number_of_occupants }}</td>
                    <td class="py-3 px-4">{{ $booking->employment_status }}</td>
                    <td class="py-3 px-4">{{ $booking->contact_method }}</td>
                    <td class="py-3 px-4">{{ $booking->message }}</td>
                    <td class="py-3 px-4 flex space-x-2">
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="inline-block bg-green-500 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded">Edit</a>
                        <button type="button" class="inline-block bg-red-500 hover:bg-red-700 text-white text-sm font-semibold py-2 px-4 rounded" onclick="showConfirmDialog('{{ route('bookings.destroy', $booking->id) }}')">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer text-center mt-8">
            <p class="text-gray-600">&copy; {{ date('Y') }} {{ config('app.name', 'Makazi Hub') }}. All rights reserved.</p>
        </div>
    </div>

    <!-- Confirmation Dialog -->
    <div id="confirmDialog" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 max-w-xs text-center shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
            <p class="mb-6">Are you sure you want to delete this item?</p>
            <div class="flex justify-center space-x-4">
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">Delete</button>
                </form>
                <button onclick="hideConfirmDialog()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        function showConfirmDialog(action) {
            document.getElementById('deleteForm').action = action;
            document.getElementById('confirmDialog').classList.remove('hidden');
        }

        function hideConfirmDialog() {
            document.getElementById('confirmDialog').classList.add('hidden');
        }
    </script>
</body>
</html>
@endsection
