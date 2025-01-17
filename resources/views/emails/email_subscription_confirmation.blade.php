<!DOCTYPE html>
<html>
<head>
    <title>Email Confirmation</title>
    <style>
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #B8EAE7;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            color: #20303a;
        }

        .email-body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #20303a;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #365B6D;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #D6BBE8;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #20303a;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Confirm Your Subscription</h1>
    </div>
    <div class="email-body">
        <p>Thank you for subscribing to our newsletter! To confirm your email subscription, please click the link below:</p>
        <a href="{{ url('subscribe/confirm/'.$token) }}" class="button">Confirm Subscription</a>
    </div>
    <div class="footer">
        <p>If you did not subscribe to this newsletter, please ignore this email.</p>
    </div>
</div>
</body>
</html>
