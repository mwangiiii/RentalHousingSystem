@extends('layouts.app')

@section('header')
<div class="flex justify-between items-center mb-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 rounded-lg shadow-md">
  <h2 class="font-semibold text-2xl">
    {{ __('Lister Houses') }}
  </h2>
</div>
@endsection

@section('content')
<div class="bg-white">
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Your Listed Houses</h2>

    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
      @forelse($houses as $house)
      <div class="group relative">
        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
          @if($house->images->isNotEmpty())
          <img src="{{ asset('storage/' . $house->images->first()->image_path) }}" alt="{{ $house->location }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
          @else
          <img src="{{ asset('images/placeholder.jpg') }}" alt="No Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
          @endif
        </div>
        <div class="mt-4 flex justify-between">
          <div>
            <h3 class="text-sm text-gray-700">
              <a href="#">
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{ $house->location }}
              </a>
            </h3>
            <p class="mt-1 text-sm text-gray-500">Contact: {{ $house->contact }}</p>
            <p class="mt-1 text-sm text-gray-500">Availability: {{ ucfirst($house->availability) }}</p>
          </div>
          <p class="text-sm font-medium text-gray-900">${{ $house->price }}</p>
        </div>
        <div class="mt-4">
          <a href="#" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors duration-300">View Details</a>
        </div>
      </div>
      @empty
      <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center">
        <p class="text-gray-500">No houses found.</p>
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection