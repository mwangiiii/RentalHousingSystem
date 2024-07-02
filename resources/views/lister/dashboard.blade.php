<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <nav class="flex space-x-4">
                <a href="{{ route('lister.listingForm')}}" class="text-gray-500 hover:text-gray-700">Add House</a>
                <a href="{{ route('lister.houses')}}" id="fetchHouses" class="text-gray-500 hover:text-gray-700">Houses</a>
                <a href="#" class="text-gray-500 hover:text-gray-700">Notifications</a>
                <a href="#" class="text-gray-500 hover:text-gray-700">Communication</a>
                <a href="#" class="text-gray-500 hover:text-gray-700">Feedback</a>
            </nav>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('House Lister Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900">Houses</h3>
            <div id="housesTableContainer" class="mt-4 overflow-x-auto">
                <table id="housesTable" class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50">Location</th>
                            <th class="px-6 py-3 bg-gray-50">Price</th>
                            <!-- <th class="px-6 py-3 bg-gray-50">Description</th> -->
                            <th class="px-6 py-3 bg-gray-50">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="housesTableBody" class="bg-white divide-y divide-gray-200">
                        @if($houses->isNotEmpty())
                            @foreach($houses as $house)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $house->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $house->price }}</td>
                                    <!-- <td class="px-6 py-4 whitespace-nowrap">{{ $house->description }}</td> -->
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
                <p id="noHousesMessage" class="text-center mt-4 text-gray-500 {{ $houses->isEmpty() ? '' : 'hidden' }}">No houses available.</p>
            </div>
        </div>

        <div id="houseDetails" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-6 hidden">
            <h3 class="text-lg font-medium text-gray-900">House Details</h3>
            <div id="houseDetailsContent"></div>
        </div>
    </div>

    <style>
        /* Button styles */
        button {
            /* Variables */
            --button_radius: 0.75em;
            --button_color: #e8e8e8;
            --button_outline_color: #000000;
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: var(--button_radius);
            background: var(--button_outline_color);
        }

        .button_top {
            display: block;
            box-sizing: border-box;
            border: 2px solid var(--button_outline_color);
            border-radius: var(--button_radius);
            padding: 0.75em 1.5em;
            background: var(--button_color);
            color: var(--button_outline_color);
            transform: translateY(-0.2em);
            transition: transform 0.1s ease;
        }

        button:hover .button_top {
            /* Pull the button upwards when hovered */
            transform: translateY(-0.33em);
        }

        button:active .button_top {
            /* Push the button downwards when pressed */
            transform: translateY(0);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fetchHousesLink = document.querySelector('a href="{{ route('lister.listingForm') }}"');
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
            fetchHousesLink.addEventListener('click', function (e) {
                e.preventDefault();
                fetchHouses();
            });

            // Event listener for viewing house details
            housesTableBody.addEventListener('click', function (e) {
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
</x-app-layout>
