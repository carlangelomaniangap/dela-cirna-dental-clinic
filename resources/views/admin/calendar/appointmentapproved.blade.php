<!DOCTYPE html>
<html>
<head>
    <title>Your Appointment has been Approved</title>
</head>
<body>

    <h1>Your Appointment has been Approved</h1>
    <p>Dear {{ $patientName }},</p>
    <p>Your appointment at {{ $dentalclinicname }} has been approved on {{ $appointmentDate }} at {{ $appointmentTime }}.</p>
    <p>Best regards,</p>
    <p>{{ $dentalclinicname }}</p>
</body>
</html>