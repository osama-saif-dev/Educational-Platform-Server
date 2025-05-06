<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="color: #333333;">New Contact Message</h2>

        <p><strong>First Name:</strong> {{ $first_name }}</p>
        <p><strong>Last Name:</strong> {{ $last_name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <hr style="margin: 20px 0;">

        <p style="white-space: pre-wrap;"><strong>Message:</strong></p>
        <p style="background-color: #f1f1f1; padding: 15px; border-radius: 5px;">
            {{ $content_message }}
        </p>
    </div>
</body>
</html>
