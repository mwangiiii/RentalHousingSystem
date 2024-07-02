@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-900 mb-6">Search Results</h1>
    @if($houses->isEmpty())
        <p class="text-lg text-gray-700">No houses found for your criteria.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($houses as $house)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ asset('makazi-hub-favicon-black.png') }}" alt="House Image" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $house->title }}</h2>
                        <p class="text-lg text-gray-700">{{ $house->location }}</p>
                        <p class="text-lg text-gray-700">{{ $house->price }} per night</p>
                        <a href="{{ route('booking.form', $house->id) }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">Book Now</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
