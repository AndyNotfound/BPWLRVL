<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #3490dc;
        }
        .info {
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Booking Confirmation</h2>
    @php
        $data = $emailData[0];
    @endphp
    <p>Hi {{ $data['details'][0]['Name'] ?? 'Guest' }},</p>

    <p>Thank you for booking with us! Here are your booking details:</p>

    <div class="info">
        <strong>Booking ID:</strong> {{ $data['Code'] ?? 'N/A' }}<br>
        <strong>Destination:</strong> {{ $data['packages'][0]['Location'] ?? 'N/A' }}<br>
        <strong>Booking Date:</strong> {{$data['details'][0]['CreatedAt'] ?? 'N/A' }}<br>
        <strong>Total Price:</strong> {{ isset($data['Price']) ? 'Rp ' . number_format($data['Price'], 0, ',', '.') : 'N/A' }}

    </div>

    <p>If you have any questions, feel free to contact us.</p>

    <div class="footer">
        <p>Batam Pesona Wisata</p>
    </div>
</div>
</body>
</html>
