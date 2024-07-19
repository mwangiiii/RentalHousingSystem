<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makazi Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .hover-grow:hover {
            transform: scale(1.05);
        }
        .bg-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">Houses in Nakuru</h1>
        <div class="container mx-auto px-4 py-6">
        @if($houses->isEmpty())
            <div class="text-center py-16">
                <svg class="mx-auto mb-4 w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 3V6h4l3 3h4m-1 6h-5l-4-4m0 0V6m0 6l4 4m0-4h-5l-4 4"></path></svg>
                <h2 class="text-2xl font-semibold text-gray-700">No listings available at the moment.</h2>
                <p class="text-gray-500">Please check back later for more apartment listings.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($houses as $house)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden hover-grow transition-transform duration-300">
                        <img src="{{ asset('storage/'.$house->main_image) }}" alt="House Image" class="w-full h-48 object-cover">
                        <div class="p-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                            <h3 class="text-xl font-semibold mb-2">{{ $house->location }}</h3>
                            <p class="mb-4">{{ Str::limit($house->description, 100) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold">${{ number_format($house->price, 2) }}</span>
                                <a href="#" class="text-yellow-300 hover:text-yellow-500">View Details</a>
                            </div>
                            <form method="POST" action="{{ route('save-house', ['houseId' => $house->id]) }}" class="mt-4">
                                @csrf
                                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-300 ease-in-out">
                                    Book Now
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    </div>

    <script>
        // JavaScript for any dynamic interactions (if needed)
    </script>
</body>
</html>
