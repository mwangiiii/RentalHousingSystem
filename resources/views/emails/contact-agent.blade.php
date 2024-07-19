<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Request for House Listing - {{ config('app.name', 'Makazi Hub') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 50px;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .content {
            line-height: 1.8;
            color: #555;
        }
        .content h2 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .content p {
            margin: 15px 0;
            font-size: 16px;
        }
        .content p strong {
            color: #333;
        }
        .footer {
            text-align: center;
            border-top: 2px solid #eaeaea;
            padding-top: 20px;
            margin-top: 30px;
        }
        .footer p {
            margin: 0;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $message->embed(public_path('makazi-hub-favicon-black.png')) }}" alt="Makazi Hub Logo">
            <h1>{{ config('app.name', 'Makazi Hub') }}</h1>
        </div>
        <div class="content">
            <h2>Contact Request for House Listing</h2>
            <p>A hunter has contacted you regarding your house listing:</p>
            <p><strong>Location:</strong> {{ $house->location }}</p>
            <p><strong>Price:</strong> {{ $house->price }}</p>
            <p><strong>Category:</strong> {{ $house->category->name }}</p>
            <p><strong>Hunter Name:</strong> {{ $hunter->name }}</p>
            <p><strong>Hunter Email:</strong> {{ $hunter->email }}</p>
            <p>Please get in touch with the hunter as soon as possible.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Makazi Hub') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
