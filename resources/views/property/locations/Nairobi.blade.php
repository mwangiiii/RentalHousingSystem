@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Houses in Nairobi</h1>
    @foreach($houses as $house)
        <div class="house">
            <h2>{{ $house->location }}</h2>
            <p>{{ $house->description }}</p>
            <p>Price: {{ $house->price }}</p>
        </div>
    @endforeach
</div>
@endsection
