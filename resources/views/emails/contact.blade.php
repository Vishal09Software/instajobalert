<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
        <h2 style="color: #0d6efd; margin-top: 0;">New Contact Form Submission</h2>
    </div>

    <div style="background-color: #ffffff; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px;">
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Subject:</strong> {{ $subject }}</p>

        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6;">
            <p><strong>Message:</strong></p>
            <p style="white-space: pre-wrap; background-color: #f8f9fa; padding: 15px; border-radius: 5px;">{{ $messageText }}</p>
        </div>
    </div>

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6; font-size: 12px; color: #6c757d; text-align: center;">
        <p>This email was sent from the contact form on {{ config('app.name') }}</p>
    </div>
</body>
</html>

