<!DOCTYPE html>
<html>
<head>
    <title>Email Confirmation</title>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Potvrdenie registrácie</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                margin: 0;
                padding: 20px;
                background-color: #f9f9f9;
            }
            p, tr, td, h3, li {
                color: black;
            }
            .email-container {
                background: #ffffff;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .email-header {
                text-align: center;
                margin-bottom: 20px;
            }
            .email-header h1 {
                color: #28a745;
            }
            .email-body {
                margin-bottom: 20px;
            }
            .button {
                display: inline-block;
                padding: 12px 25px;
                background-color: #28a745;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 20px;
                font-size: 16px;
                font-weight: bold;
                text-align: center;
                transition: background-color 0.3s ease;
            }
            .button:hover {
                background-color: #218838;
            }
            .email-footer {
                text-align: center;
                font-size: 0.9em;
                color: #888;
            }
        </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Potvrďte svoju registráciu</h1>
    </div>
    <div class="email-body">
        <p>Ďakujeme, že ste sa prihlásili na odber nášho newslettera! Aby sme potvrdili vašu registráciu, kliknite prosím na odkaz nižšie:</p>
        <a href="{{ url('subscribe/confirm/'.$token) }}" class="button">Potvrdiť registráciu</a>
    </div>
    <div class="footer">
        <p>Ak ste sa na tento newsletter neprihlásili, tento e-mail jednoducho ignorujte.</p>
    </div>
</div>
</body>
</html>
