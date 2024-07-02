@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-semibold mb-6">Apartments</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($houses as $house)
            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg">
                <img class="rounded-t-lg" src="{{ $house->image_path ?? asset('default-house.jpg') }}" alt="{{ $house->location }}">
                <div class="p-5">
                    <h2 class="text-2xl font-bold mb-2">{{ $house->location }}</h2>
                    <p class="text-gray-700 mb-4">{{ $house->description }}</p>
                    <p class="text-lg font-semibold">Price: ${{ $house->price }}</p>
                    <a href="{{ route('booking.show', $house->id) }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">View Details</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
