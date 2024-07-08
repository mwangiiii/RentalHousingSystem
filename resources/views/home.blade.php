<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('makazi-hub-favicon-black.png',true) }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('style.css',true) }}">
    <title>{{ config('app.name', 'Makazi Hub') }}</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('makazi-hub logo.jpg') }}" alt="Makazi Hub">
        </div>

        <div class="nav-container">
            <div class="menu">
                <div class="relative group">
                    <a href="#" class="text-gray-700 hover:text-black focus:outline-none">Categories</a>
                    <ul class="absolute left-0 hidden bg-white text-gray-700 pt-1 group-hover:block z-10">
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/category/apartment">Apartment</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/category/own-compound">Own Compound</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/category/gated-community">Gated Community Spaces</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/category/townhouses">Townhouses</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/category/commercial-properties">Commercial Properties</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/category/short-term-rentals">Short-Term Rentals</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/category/luxury-villas">Luxury Villas</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/category/property-management-services">Property Management Services</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/properties/category/{contact-us}">Contact Us</a></li>
                    </ul>
                </div>

                <div class="relative group">
                    <a href="#" class="text-gray-700 hover:text-black focus:outline-none">Popular Locations</a>
                    <ul class="absolute left-0 hidden bg-white text-gray-700 pt-1 group-hover:block z-10">
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/location/nairobi">Nairobi</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/location/nakuru">Nakuru</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/location/mombasa">Mombasa</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/location/kirinyaga">Kirinyaga</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/location/eldoret">Eldoret</a></li>
                        <li><a class="block px-4 py-2 whitespace-no-wrap bg-gray-200 hover:bg-gray-400" href="/property/location/embu">Embu</a></li>
                    </ul>
                </div>

                <div class="relative group">
                    <a href="#" class="text-gray-700 hover:text-black focus:outline-none">Favourites</a>
                    <ul class="absolute left-0 hidden bg-white text-gray-700 pt-1 group-hover:block z-10"></ul>
                </div>
            </div>

            <div class="auth-links">
                @auth
                <a href="{{ url('/dashboard') }}">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}">
                    <button class="button">
                        <span class="text">Login</span>
                    </button>
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}">
                    <button class="button">
                        <span class="text">Register</span>
                    </button>
                </a>
                @endif
                @endauth
            </div>
        </div>
    </header>

    <div style="position: relative;">
        <img class="background-image" src="{{ asset('anthony.jpg') }}" alt="Background Image">
        <section class="search-section">
            <div class="content">
                <h1>Find A Rental House Near You</h1>
                <div class="tabs">
                    <button class="tab active">Rent</button>
                    <button class="tab">Sale</button>
                    <button class="tab">Furnished</button>
                    <button class="tab">Land</button>
                </div>
                <div class="search-bar">
                    <input type="text" id="locationInput" placeholder="Enter Location, workplace or school, etc">
                    <select id="criteriaInput">
                        <option value="all-bedrooms">All Bedrooms</option>
                        <option value="apartment">Apartment</option>
                        <option value="own-compound">Own Compound</option>
                        <option value="gated-community">Gated Community Spaces</option>
                        <option value="townhouses">Townhouses</option>
                        <option value="commercial-properties">Commercial Properties</option>
                        <option value="short-term-rentals">Short-Term Rentals</option>
                        <option value="luxury-villas">Luxury Villas</option>
                        <option value="property-management-services">Property Management Services</option>
                    </select>
                    <div class="price-range">
                        <input type="number" placeholder="Min Amount" id="minAmount">
                        <input type="number" placeholder="Max Amount" id="maxAmount">
                    </div>
                    <button class="search-button">Find Rental House</button>

                    <script>
                        function searchFunction(location, criteria, minAmount, maxAmount) {
                            let url = '/search';
                            const params = [];

                            if (location) params.push('location=' + encodeURIComponent(location));
                            if (criteria && criteria !== 'all-bedrooms') params.push('category=' + encodeURIComponent(criteria));
                            if (minAmount) params.push('min_amount=' + encodeURIComponent(minAmount));
                            if (maxAmount) params.push('max_amount=' + encodeURIComponent(maxAmount));

                            if (params.length > 0) url += '?' + params.join('&');

                            // Redirect to the search URL
                            window.location.href = url;
                        }

                        // Assuming you have input fields for location, description, and criteria
                        const locationInput = document.getElementById('locationInput');
                        const criteriaInput = document.getElementById('criteriaInput');
                        const minAmountInput = document.getElementById('minAmount');
                        const maxAmountInput = document.getElementById('maxAmount');
                        const searchButton = document.querySelector('.search-button');

                        searchButton.addEventListener('click', () => {
                            const location = locationInput.value;
                            const criteria = criteriaInput.value;
                            const minAmount = minAmountInput.value;
                            const maxAmount = maxAmountInput.value;
                            searchFunction(location, criteria, minAmount, maxAmount);
                        });
                    </script>
                </div>
            </div>
        </section>
    </div>

    <main>
        <br />
        <h2>
            <p style="text-align: center; margin-left: 30%; margin-right: 30%; margin-top:2%; margin-bottom:5%; font-size:1.5em;"> Houses For Sale </p>
        </h2>

        <div class="carouselContainer">
            <div class="housesContainer">
                @if($houses->isEmpty())
                <p>No houses available</p>
                @else
                @foreach ($houses as $house)
                <div class="house">
                    <div class="image-container">
                        @if($house->mainImage)
                        <img src="{{ asset('storage/' . $house->mainImage->is_main) }}" alt="Image of {{ $house->location }}">
                        @else
                        <p>No images available</p>
                        @endif
                    </div>
                    <div class="house-content">
                        <h1>{{ $house->location }}</h1>
                        <p>Price: {{ $house->price }}</p>
                        <p>Availability: {{ $house->availability }}</p>
                        <p>Contact: {{ $house->contact }}</p>
                        <p>Description: {{ $house->description }}</p>
                        <p>Amenities: {{ $house->amenities }}</p>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const housesData = <?php echo json_encode($houses) ?>;
                const housesContainer = document.querySelector('.housesContainer');

                housesData.forEach(house => {
                    const houseDiv = document.createElement('div');
                    houseDiv.classList.add('house');
                    houseDiv.innerHTML = `
                        <div class="image-container">
                            ${house.mainImage ? `<img src="/storage/${house.mainImage.is_main}" alt="Image of ${house.location}">` : '<p>No images available</p>'}
                        </div>
                        <div class="house-content">
                            <h2>${house.location}</h2>
                            <p>${house.description}</p>
                            <p>Price: ${house.price}</p>
                            <p>Availability: ${house.availability}</p>
                            <p>Contact: ${house.contact}</p>
                        </div>
                    `;
                    housesContainer.appendChild(houseDiv);
                });

                let currentOffset = 0;
                const rowsToShow = 4;
                const rowHeight = 320; // Adjust based on card height
                const totalRows = Math.ceil(housesData.length / 3);
                const containerHeight = rowsToShow * rowHeight;

                setInterval(() => {
                    currentOffset += containerHeight;
                    if (currentOffset >= totalRows * rowHeight) {
                        currentOffset = 0;
                    }
                    housesContainer.style.transform = `translateY(-${currentOffset}px)`;
                }, 5000); // Change every 5 seconds
            });
        </script>


        <br />

        <div class="operation" style="margin-top:5%">
            <h2 style="text-align: center; margin-left: 30%; margin-right: 30%; margin-top:2%; margin-bottom:5%; font-size:2em;">How It Works</h2>
            <div class="container">
                <div data-text="Search" style="--r:-20; font-size:20px; font:bold;" class="glass">
                    <img style="width:100%; height:auto; max-width:100%; max-height:100%;" src="{{ asset('search-image.png') }}" alt="Search Image">
                </div>

                <div data-text="Review Feedback" style="--r:5; font-size:20px;" class="glass">
                    <img style="width:100%; height:auto; max-width:100%; max-height:100%; margin-top:0;" src="{{ asset('product-reviews.jpeg') }}">
                </div>

                <div data-text="Contact Landlord" style="--r:5;font-size:20px;" class="glass">
                    <img style="width:100%; height:auto; max-width:100%; max-height:100%; margin-top:0;" src="{{ asset('contact-us.png') }}" alt="Example photo of landlord">
                </div>

                <div data-text="View the House" style="--r:5;font-size:20px;" class="glass">
                    <img style="width: 100%; height: auto; max-width: 100%; max-height: 100%; margin-top: 0; object-fit: cover;" src="{{ asset('view-house.png') }}" alt="View the House Image">
                </div>

                <div data-text="Formal Documentation" style="--r:5; font-size:17px;" class="glass">
                    <img style="width: 100%; height: auto; max-width: 100%; max-height: 100%; margin-top: 0; object-fit: cover;" src="{{ asset('documentation.png') }}" alt="Documentation Image">
                </div>

                <div data-text="Move In" style="--r:25; font:bold; font-size:20px;" class="glass">
                    <img style="width: 100%; height: auto; max-width: 100%; max-height: 100%; margin-top: 0; object-fit: cover;" src="{{ asset('image.png') }}" alt="Move-in Image">
                </div>
            </div>
        </div>

        <x-footer />
    </main>
</body>

</html>