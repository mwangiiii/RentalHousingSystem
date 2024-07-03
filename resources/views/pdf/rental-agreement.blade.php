<!DOCTYPE html>
<html>
<head>
    <title>Rental Agreement</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2, h3, h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
        }

        .details, .signatures {
            margin: 20px 0;
        }

        .details p, .signatures p {
            margin: 5px 0;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
        }

        .signature-box p {
            margin-top: 40px;
            border-top: 1px solid #000;
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            margin-top: 30px;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rental Agreement</h1>

        <h3>Landlord Details</h3>
        <div class="details">
            <p><strong>Landlord:</strong> {{ $landlord->name }}</p>
            <p><strong>Phone Number:</strong> {{ $landlord->phone_number }}</p>
            <p><strong>Email:</strong> {{ $landlord->email }}</p>
        </div>

        <h3>Tenant Details</h3>
        <div class="details">
            <p><strong>Tenant:</strong> {{ $tenant->name }}</p>
            <p><strong>Phone Number:</strong> {{ $tenant->phone_number }}</p>
            <p><strong>Email:</strong> {{ $tenant->email }}</p>
        </div>

        <h3>Property Details</h3>
        <div class="details">
            <p><strong>Property:</strong> {{ $property->name }}</p>
            <p><strong>Address:</strong> {{ $property->address }}</p>
            <p><strong>Description:</strong> {{ $property->description }}</p>
        </div>

        <h3>Lease Details</h3>
        <div class="details">
            <p><strong>Room Number:</strong> {{ $room->room_number }}</p>
            <p><strong>Rent Amount:</strong> ${{ $room->rent }}</p>
            <p><strong>Lease Start Date:</strong> {{ $leaseStart->format('M d, Y') }}</p>
            <p><strong>Lease End Date:</strong> {{ $leaseEnd->format('M d, Y') }}</p>
        </div>

        <h3 class="section-title">Signatures</h3>
        <div class="signatures">
            <div class="signature-box">
                <p>Landlord Signature</p>
            </div>
            <div class="signature-box">
                <p>Tenant Signature</p>
            </div>
        </div>
    </div>
</body>
</html>
