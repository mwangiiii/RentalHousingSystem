<!DOCTYPE html>
<html>
<head>
    <title>Makazi Hub - Booking Update Notification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
        .content ul {
            list-style-type: none;
            padding: 0;
            margin: 15px 0;
        }
        .content ul li {
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #eaeaea;
            border-radius: 4px;
            font-size: 16px;
        }
        .content ul li b {
            color: #007bff;
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
            <h1>Makazi Hub</h1>
        </div>
        <div class="content">
            <h2>Booking Update Notification</h2>
            <p>Dear {{ $house->lister->name }},</p>
            <p>The booking for your house located at {{ $house->location }} has been updated.</p>
            <p><strong>Updated Booking Details:</strong></p>
            <ul>
                <li><b>Move-in Date:</b> {{ $booking->move_in_date }}</li>
                <li><b>Lease Duration:</b> {{ $booking->lease_duration }} months</li>
                <li><b>Number of Occupants:</b> {{ $booking->number_of_occupants }}</li>
                <li><b>Employment Status:</b> {{ $booking->employment_status }}</li>
                <li><b>Contact Method:</b> {{ $booking->contact_method }}</li>
                <li><b>Message:</b> {{ $booking->message }}</li>
            </ul>
            <p>Please contact Makazi Hub for more information.</p>
            <p>Thank you for using our service.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Makazi Hub. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
