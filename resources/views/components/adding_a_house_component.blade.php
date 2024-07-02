<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add House</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .input-container {
            position: relative;
            margin-bottom: 30px;
        }
        .input-field, .input-file {
            font-size: 18px;
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            background-color: #fff;
            outline: none;
            transition: border-color 0.3s;
        }
        .input-field:focus, .input-file:focus {
            border-color: #007bff;
        }
        .label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
            color: #495057;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .error-messages {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
    <form action="{{ route('addListing.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="availability">Availability</label>
            <input type="text" name="availability" id="availability" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="rules_and_regulations">Rules and Regulations</label>
            <textarea name="rules_and_regulations" id="rules_and_regulations" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="amenities">Amenities</label>
            <textarea name="amenities" id="amenities" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category_id" id="category" class="input-field" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="main_image">Main Image</label>
            <input type="file" name="main_image" id="main_image" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="home_images">Additional Images</label>
            <input type="file" name="home_images[]" id="home_images" class="form-control" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Add Listing</button>
    </form>
</div>

</body>
</html>
