@extends('layouts.app')

@section('header')
<div class="flex justify-between items-center mb-6">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('House Lister Dashboard') }}
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
                        <th class="px-6 py-3 bg-gray-50">Category</th>
                        <th class="px-6 py-3 bg-gray-50">Actions</th>
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
                                <button class="action-button view-details" data-id="{{ $house->id }}">
                                    <span class="button_top">View Details</span>
                                </button>
                                <button class="action-button modify-house ml-2">
                                    <span class="button_top">Modify House</span>
                                </button>
                                <button class="action-button view-bookings ml-2">
                                    <span class="button_top">View Bookings</span>
                                </button>
                                <button class="action-button delete-house ml-2">
                                    <span class="button_top">Delete House</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No houses found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <!-- <p id="noHousesMessage" class="text-center mt-4 text-gray-500 {{ $houses->isEmpty() ? '' : 'hidden' }}">No houses available.</p> -->
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
        // const fetchHousesLink = document.querySelector('a[href="{{ route('lister.listingForm') }}"]');  
        const housesTableContainer = document.getElementById('housesTableContainer');
        const noHousesMessage = document.getElementById('noHousesMessage');
        const housesTableBody = document.getElementById('housesTableBody');
        const houseDetails = document.getElementById('houseDetails');

        // Function to fetch houses
        const fetchHouses = () => {
            fetch('/houses')
                .then(response => response.json())
                .then(data => {
                    housesTableBody.innerHTML = '';
                    if (data.length === 0) {
                        noHousesMessage.classList.remove('hidden');
                        housesTableContainer.classList.add('hidden');
                        houseDetails.classList.add('hidden');
                    } else {
                        noHousesMessage.classList.add('hidden');
                        housesTableContainer.classList.remove('hidden');
                        houseDetails.classList.add('hidden');
                        data.forEach(house => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                    <td class="px-6 py-4 whitespace-nowrap">${house.location}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${house.price}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${house.description}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button class="action-button view-details" data-id="${house.id}">
                                            <span class="button_top">View Details</span>
                                        </button>
                                        <button class="action-button modify-house ml-2">
                                            <span class="button_top">Modify House</span>
                                        </button>
                                        <button class="action-button view-bookings ml-2">
                                            <span class="button_top">View Bookings</span>
                                        </button>
                                        <button class="action-button delete-house ml-2">
                                            <span class="button_top">Delete House</span>
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

        // Event listener for fetching houses again on click
        // fetchHousesLink.addEventListener('click', function(e) {
        //     e.preventDefault();
        //     fetchHouses();
        // });

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
                                <p><strong>Contact:</strong> ${house.contact}</p>
                                <p><strong>Amenities:</strong> ${house.amenities}</p>
                            `;
                        houseDetails.classList.remove('hidden');
                        housesTableContainer.classList.add('hidden');
                    })
                    .catch(error => {
                        console.error('Error fetching house details:', error);
                    });
            }
        });
    });
</script>
@endsection