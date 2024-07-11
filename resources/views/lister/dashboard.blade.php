@extends('layouts.app')

@section('header')
<div class="flex justify-between items-center mb-6">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('House Lister Dashboard') }}
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
                        <tr id="house-row-{{ $house->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $house->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $house->price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $house->category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300 ease-in-out view-details" data-id="{{ $house->id }}">
                                    View Details
                                </button>
                                <a href="{{ route('houses.edit', $house->id) }}">
                                <button class="bg-green-500 text-white px-4 py-2 rounded ml-2 hover:bg-green-700 transition duration-300 ease-in-out modify-house">
                                    Modify House
                                </button>
</a>
                                <button class="bg-yellow-500 text-white px-4 py-2 rounded ml-2 hover:bg-yellow-700 transition duration-300 ease-in-out view-bookings">
                                    View Bookings
                                </button>
                                <form action="{{ url('/house/destroy', ['id' => $house->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded ml-2 hover:bg-red-700 transition duration-300 ease-in-out">
                                        Delete House
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No houses found.</td>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                            row.id = `house-row-${house.id}`;
                            row.innerHTML = `
                                <td class="px-6 py-4 whitespace-nowrap">${house.location}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${house.price}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${house.category.name}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300 ease-in-out view-details" data-id="${house.id}">
                                        View Details
                                    </button>
                                    <button class="bg-green-500 text-white px-4 py-2 rounded ml-2 hover:bg-green-700 transition duration-300 ease-in-out modify-house">
                                        Modify House
                                    </button>
                                    <button class="bg-yellow-500 text-white px-4 py-2 rounded ml-2 hover:bg-yellow-700 transition duration-300 ease-in-out view-bookings">
                                        View Bookings
                                    </button>
                                    <form action="/house/destroy/${house.id}" method="POST" style="display:inline;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded ml-2 hover:bg-red-700 transition duration-300 ease-in-out">
                                            Delete House
                                        </button>
                                    </form>
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
                            <p><strong>Category:</strong> ${house.category.name}</p>
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
