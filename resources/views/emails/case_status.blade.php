<!DOCTYPE html>
<html>
<head>
    <title>Case Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">

    <h2 style="color: #1d4ed8;">Law Firm Client Portal Update</h2>
    
    <p>Hello <strong>{{ $consultation->user->name }}</strong>,</p>

    <p>We are writing to inform you that the status of your legal request regarding <strong>"{{ $consultation->legal_category }}"</strong> has been updated.</p>

    <p style="background-color: #f3f4f6; padding: 15px; border-left: 4px solid #1d4ed8;">
        <strong>New Status:</strong> <span style="text-transform: uppercase; color: #b91c1c;">{{ $consultation->status }}</span><br>
        <strong>Your Case Description:</strong> {{ Str::limit($consultation->description, 50) }}
    </p>

    <p>Please log in to your Client Portal to view more details.</p>

    <p>Thank you,<br><strong>The Legal Team</strong></p>

</body>
</html>