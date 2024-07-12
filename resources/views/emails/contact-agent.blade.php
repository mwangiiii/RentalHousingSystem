<!DOCTYPE html>
<html>
<head>
    
    <title>{{ config('app.name', 'Makazi Hub') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('makazi-hub-favicon-black.png') }}">
</head>
<body>
    <h1>Contact Request for House Listing</h1>
    <p>A hunter has contacted you regarding your house listing:</p>
    <p><strong>Location:</strong> {{ $house->location }}</p>
    <p><strong>Price:</strong> {{ $house->price }}</p>
    <p><strong>Category:</strong> {{ $house->category->name }}</p>
    <p><strong>Hunter Name:</strong> {{ $hunter->name }}</p>
    <p><strong>Hunter Email:</strong> {{ $hunter->email }}</p>
    <p>Please get in touch with the hunter as soon as possible.</p>
</body>
</html>
