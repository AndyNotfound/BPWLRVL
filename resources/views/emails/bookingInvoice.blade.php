<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Invoice</title>
</head>
@php
    $data = $emailData[0];
@endphp
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #3490dc; margin-bottom: 20px;">Booking Invoice</h2>


        <p>Hello {{ $data['Detail']['Name'] ?? 'Customer' }},</p>

        <p>Thank you for booking with <strong>Batam Pesona Wisata</strong>. Here are your booking details:</p>

        <div>
            <p><strong>Booking ID:</strong> {{ $data['Code'] ?? 'PKG - XXXX' }}</p>
            <p><strong>Name:</strong> {{ $data['Detail']['Name'] ?? 'Customer' }}</p>
            <p><strong>Travel Package:</strong> {{ $data['Package']['Name'] }}</p>
            <p><strong>Booking Date:</strong> {{ $data['Detail']['EnterDate'] }}</p>
            <p><strong>Pax:</strong> {{ $data['Detail']['TotalPax'] }} </p>
        </div>

        <div style="margin-top: 50px;">
            <p><strong>Total Price:</strong> Rp {{ number_format($data['Detail']['Price'], 0, ',', '.') }}</p>
        </div>

        <p>If you have any questions, feel free to contact our support.</p>

        <div style="margin-top: 30px; font-size: 0.9em; color: #777;">
            <p>Regards,<br><strong>Batam Pesona Wisata</strong></p>
        </div>
    </div>
</body>
</html>

why the fuck my github doesn't count this?