@extends('layouts.app')

@section('header')
<div class="flex justify-between items-center mb-6">
    <nav class="flex space-x-4">
        <a href="#" class="text-gray-500 hover:text-gray-700">Search Houses</a>
        <a href="#" class="text-gray-500 hover:text-gray-700">Saved Houses</a>
        <a href="#" class="text-gray-500 hover:text-gray-700">Notifications</a>
        <a href="#" class="text-gray-500 hover:text-gray-700">Messages</a>
        <a href="#" class="text-gray-500 hover:text-gray-700">Feedback</a>
    </nav>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('House Hunter Dashboard') }}
    </h2>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Houses</h3>
        <div id="housesTableContainer" class="mt-4 overflow-x-auto">
            <table id="housesTable" class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50">Location</th>
                        <th class="px-6 py-3 bg-gray-50">Price</th>
                        <th class="px-6 py-3 bg-gray-50">Description</th>
                        <th class="px-6 py-3 bg-gray-50">Image</th>
                        <th class="px-6 py-3 bg-gray-50">Actions</th>
                    </tr>
                </thead>
                <tbody id="housesTableBody" class="bg-white divide-y divide-gray-200">
                    {{-- Blade directives outside of JavaScript/HTML context --}}
                    @foreach($houses as $house)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $house->location }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $house->price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $house->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($house->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $house->images->first()->image_path) }}" alt="House Image" class="w-16 h-16 object-cover">
                            @else
                            No image available
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button class="action-button view-details" data-id="{{ $house->id }}">
                                <span class="button_top">View Details</span>
                            </button>
                            <button class="action-button save-house ml-2">
                                <span class="button_top">Save House</span>
                            </button>
                            <button class="action-button contact-listing-agent ml-2">
                                <span class="button_top">Contact Agent</span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @empty($houses)
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No houses found.</td>
                    </tr>
                    @endempty
                </tbody>
            </table>
            <p id="noHousesMessage" class="text-center mt-4 text-gray-500 {{ $houses->isEmpty() ? '' : 'hidden' }}">No houses available.</p>
        </div>
    </div>

    <div id="houseDetails" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-6 hidden">
        <h3 class="text-lg font-medium text-gray-900">House Details</h3>
        <div id="houseDetailsContent"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const housesTableBody = document.getElementById('housesTableBody');
        const houseDetails = document.getElementById('houseDetails');

        // Function to fetch houses
        const fetchHouses = () => {
            fetch('/houses')
                .then(response => response.json())
                .then(data => {
                    housesTableBody.innerHTML = '';
                    if (data.length === 0) {
                        document.getElementById('noHousesMessage').classList.remove('hidden');
                        housesTableContainer.classList.add('hidden');
                        houseDetails.classList.add('hidden');
                    } else {
                        document.getElementById('noHousesMessage').classList.add('hidden');
                        housesTableContainer.classList.remove('hidden');
                        houseDetails.classList.add('hidden');
                        data.forEach(house => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                    <td class="px-6 py-4 whitespace-nowrap">${house.location}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${house.price}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${house.description}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="/storage/${house.images[0].image_path}" alt="House Image" class="w-16 h-16 object-cover">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button class="action-button view-details" data-id="${house.id}">
                                            <span class="button_top">View Details</span>
                                        </button>
                                        <button class="action-button save-house ml-2">
                                            <span class="button_top">Save House</span>
                                        </button>
                                        <button class="action-button contact-listing-agent ml-2">
                                            <span class="button_top">Contact Agent</span>
                                        </button>
                                    </td>
                                `;
                            housesTableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching houses:', error);
                });
        };

        // Fetch houses on initial load
        fetchHouses();

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
    });
</script>
@endsection