<!DOCTYPE html>
<html>
<head>
    <title>House Viewing Request</title>
</head>
<body>
    <p>Dear {{ $house->lister->name }},</p>
    <p>A viewing has been scheduled for your house, "{{ $house->name }}".</p>
    <p><strong>Date:</strong> {{ $viewingTime->format('Y-m-d') }}</p>
    <p><strong>Time:</strong> {{ $viewingTime->format('H:i') }}</p>
    <p>Please contact the hunter if you have any questions.</p>
    <p>Thank you,</p>
    <p>Your Application Name</p>
</body>
</html>
