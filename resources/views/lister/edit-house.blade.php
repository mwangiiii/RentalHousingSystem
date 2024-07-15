@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="pt-6">
        <nav aria-label="Breadcrumb">
            <ol role="list" class="mx-auto flex max-w-2xl items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <li>
                    <div class="flex items-center">
                        <a href="{{ route('houses.index') }}" class="mr-2 text-sm font-medium text-gray-900">Houses</a>
                        <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true" class="h-5 w-4 text-gray-300">
                            <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                        </svg>
                    </div>
                </li>
                <li class="text-sm">
                    <a href="#" aria-current="page" class="font-medium text-gray-500 hover:text-gray-600">{{ $house->location }}</a>
                </li>
            </ol>
        </nav>

        <!-- Image gallery -->
        <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
            @foreach ($house->images as $image)
                <div class="aspect-h-4 aspect-w-3 overflow-hidden rounded-lg relative">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="House image" class="h-full w-full object-cover object-center">
                    <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700 focus:outline-none" onclick="deleteImage({{ $image->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>

        <!-- House info -->
        <div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
            <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $house->location }}</h1>
                <p class="mt-2 text-lg text-gray-900">${{ $house->price }}</p>
            </div>

            <!-- Edit form -->
            <div class="mt-4 lg:row-span-3 lg:mt-0">
                <h2 class="sr-only">House information</h2>

                <form action="{{ route('houses.update', $house->id) }}" method="POST" enctype="multipart/form-data" class="mt-10">
                    @csrf
                    @method('PUT')

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $house->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="mt-6">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ $house->location }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Price -->
                    <div class="mt-6">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" value="{{ $house->price }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $house->description }}</textarea>
                    </div>

                    <!-- Amenities -->
                    <div class="mt-6">
                        <label for="amenities" class="block text-sm font-medium text-gray-700">Amenities</label>
                        <input type="text" name="amenities" id="amenities" value="{{ $house->amenities }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Contact -->
                    <div class="mt-6">
                        <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                        <input type="text" name="contact" id="contact" value="{{ $house->contact }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Rules and Regulations -->
                    <div class="mt-6">
                        <label for="rules_and_regulations" class="block text-sm font-medium text-gray-700">Rules and Regulations</label>
                        <textarea name="rules_and_regulations" id="rules_and_regulations" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $house->rules_and_regulations }}</textarea>
                    </div>

                    <!-- Main Image -->
                    <div class="mt-6">
                        <label for="main_image" class="block text-sm font-medium text-gray-700">Main Image</label>
                        <input type="file" name="main_image" id="main_image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Additional Images -->
                    <div class="mt-6">
                        <label for="images" class="block text-sm font-medium text-gray-700">Upload Additional House Images</label>
                        <small class="form-text text-muted">Please select and upload other images of the house to provide a comprehensive view.</small>
                        <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Availability -->
                    <div class="col-span-6 sm:col-span-4 mt-6">
                        <x-label for="availability" :value="('Availability')" />
                        <x-radio-button-group name="availability" :options="['available' => 'Available', 'unavailable' => 'Unavailable', 'booked' => 'Booked']" selected="{{ old('availability') ?? $house->availability ?? '' }}" /> 
                        <x-input-error for="availability" class="mt-2" />
                    </div>

                    <button type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update House</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteImage(imageId) {
        // Implement the AJAX request to delete the image
        fetch(`/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the image element from the DOM
                document.querySelector(`button[onclick="deleteImage(${imageId})"]`).parentElement.remove();
            }
        })
        .catch(error => {
            console.error('Error deleting image:', error);
        });
    }
</script>
@endsection
