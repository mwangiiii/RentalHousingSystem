<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makazi Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('makazi-hub-favicon-black.png') }}">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4 text-gray-600">
                <li><a href="#" class="hover:text-gray-900">Home</a></li>
                <li>&gt;</li>
                <li><a href="#" class="hover:text-gray-900">Listings</a></li>
                <li>&gt;</li>
                <li class="text-gray-500">House Details</li>
            </ol>
        </nav>
        
        <div class="bg-white rounded-lg shadow-md mt-6 p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="col-span-1">
                    <!-- Display the main image -->
                    @if($house->images->where('is_main', '!=', null)->first())
                        <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $house->images->where('is_main', '!=', null)->first()->image_path) }}" alt="House Image" class="object-cover w-full h-full">
                        </div>
                    @endif

                    <!-- Display additional images -->
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        @foreach($house->images->where('is_main', null) as $image)
                            <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="House Image {{ $loop->index + 1 }}" class="object-cover w-full h-full">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $house->location }}</h1>
                    <p class="text-xl text-indigo-600 mt-2">${{ number_format($house->price, 2) }}</p>

                    <div class="mt-4">
                        <h2 class="text-lg font-semibold text-gray-900">Description</h2>
                        <p class="text-gray-700 mt-2">{{ $house->description }}</p>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-900">Details</h2>
                        <table class="w-full mt-2 text-left text-gray-700">
                            <tbody>
                                <tr class="border-b">
                                    <th class="py-2 px-4 font-medium text-gray-900">Location</th>
                                    <td class="py-2 px-4">{{ $house->location }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="py-2 px-4 font-medium text-gray-900">Price</th>
                                    <td class="py-2 px-4">${{ number_format($house->price, 2) }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="py-2 px-4 font-medium text-gray-900">Availability</th>
                                    <td class="py-2 px-4">{{ ucfirst($house->availability) }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="py-2 px-4 font-medium text-gray-900">Contact</th>
                                    <td class="py-2 px-4">{{ $house->contact }}</td>
                                </tr>
                                @if($house->rules_and_regulations)
                                    <tr class="border-b">
                                        <th class="py-2 px-4 font-medium text-gray-900">Rules and Regulations</th>
                                        <td class="py-2 px-4">{{ $house->rules_and_regulations }}</td>
                                    </tr>
                                @endif
                                <tr class="border-b">
                                    <th class="py-2 px-4 font-medium text-gray-900">Amenities</th>
                                    <td class="py-2 px-4">{{ $house->amenities }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button class="mt-6 w-full bg-indigo-600 text-white py-3 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Contact Agent
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</body>
</html>
