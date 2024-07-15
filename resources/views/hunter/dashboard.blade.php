@extends('layouts.app')

@section('header')
<div class="flex justify-between items-center mb-6">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('House Hunter Dashboard') }}
    </h2>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <div class="bg-white shadow-xl rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Houses</h3>
        <div id="housesTableContainer" class="overflow-x-auto">
            <table id="housesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="housesTableBody" class="bg-white divide-y divide-gray-200">
                    @if($houses->isNotEmpty())
                        @foreach($houses as $house)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $house->location }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $house->price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $house->category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('houseshunter.show', ['id' => $house->id]) }}">
                                        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300 ease-in-out view-details">
                                            View Details
                                        </button>
                                    </a>
                                    <a href="">
                                        <button class="bg-green-500 text-white px-4 py-2 rounded ml-2 hover:bg-green-700 transition duration-300 ease-in-out save-house" data-id="{{ $house->id }}">
                                            Save House
                                        </button>
                                    </a>
                                    <form action="{{ route('contact.agent', ['houseId' => $house->id]) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded ml-2 hover:bg-yellow-700 transition duration-300 ease-in-out">
                                            Contact Agent
                                        </button>
                                    </form>
                                    <a href="{{ route('booking.form', ['houseId' => $house->id]) }}">
                                        <button class="bg-purple-500 text-white px-4 py-2 rounded ml-2 hover:bg-purple-700 transition duration-300 ease-in-out">
                                            Book Now
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No houses found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div id="houseDetails" class="bg-white shadow-xl rounded-lg p-6 mt-6 hidden">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">House Details</h3>
        <div id="houseDetailsContent"></div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const housesTableBody = document.getElementById('housesTableBody');
        const houseDetails = document.getElementById('houseDetails');

        // Event listener for viewing house details
        housesTableBody.addEventListener('click', function(e) {
            if (e.target.closest('.view-details')) {
                const houseId = e.target.closest('.view-details').getAttribute('data-id');
                fetch(`/houses/${houseId}`)
                    .then(response => response.json())
                    .then(house => {
                        const detailsContent = document.getElementById('houseDetailsContent');
                        detailsContent.innerHTML = `
                            <p><strong>Location:</strong> ${house.location}</p>
                            <p><strong>Price:</strong> ${house.price}</p>
                            <p><strong>Category:</strong> ${house.category.name}</p>
                            <p><strong>Description:</strong> ${house.description}</p>
                            <p><strong>Availability:</strong> ${house.availability}</p>
                            <div class="mt-4">
                                <h4 class="font-medium text-gray-900">Images</h4>
                                <div class="grid grid-cols-3 gap-4 mt-2">
                                    ${house.images.map(image => `
                                        <img src="/storage/${image.image_path}" alt="House Image" class="w-full h-32 object-cover">
                                    `).join('')}
                                </div>
                            </div>
                        `;
                        houseDetails.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error fetching house details:', error);
                    });
            }
        });

        // Event listener for saving houses
        housesTableBody.addEventListener('click', function(e) {
            if (e.target.closest('.save-house')) {
                const houseId = e.target.closest('.save-house').getAttribute('data-id');
                fetch(`/hunter/save-house`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ house_id: houseId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('House saved successfully.');
                    } else {
                        alert('Failed to save house.');
                    }
                })
                .catch(error => {
                    console.error('Error saving house:', error);
                });
            }
        });
    });
</script>
@endsection
