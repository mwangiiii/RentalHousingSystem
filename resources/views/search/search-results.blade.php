<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makazi Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('makazi-hub-favicon-black.png') }}">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .property-card {
            margin: 20px 0;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .property-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .property-image {
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .property-card:hover .property-image {
            transform: scale(1.1);
        }
        .property-info {
            padding: 20px;
            background-color: #ffffff;
            border-top: 1px solid #f0f0f0;
        }
        .property-price {
            color: #28a745;
            font-weight: bold;
            font-size: 1.5em;
        }
        .property-location {
            color: #6c757d;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .no-results {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Search Results</h1>
        <div class="row">
            @forelse($houses as $house)
                <div class="col-md-4">
                    <div class="card property-card">
                        @if($house->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $house->images->first()->image_path) }}" class="card-img-top property-image" alt="Property Image">
                        @else
                            <img src="{{ asset('images/property-placeholder.jpg') }}" class="card-img-top property-image" alt="Property Image">
                        @endif
                        <div class="card-body property-info">
                            <h5 class="card-title">{{ $house->name }}</h5>
                            <p class="card-text">{{ Str::limit($house->description, 100) }}</p>
                            <p class="property-price">${{ number_format($house->price) }}</p>
                            <p class="property-location"><i class="fas fa-map-marker-alt"></i> {{ $house->location }}</p>
                            <a href="{{ route('houseshunter.show', ['id' => $house->id]) }}" class="btn btn-primary"><i class="fas fa-info-circle"></i> View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 no-results">
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> No properties found</h4>
                        <p>Sorry, we couldn't find any properties matching your search criteria. Please try adjusting your filters.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
