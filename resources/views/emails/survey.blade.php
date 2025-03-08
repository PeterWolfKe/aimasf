<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Požiadanie o vyplnenie prieskumu</title>
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
            color: #28a745; /* Using the same green as your example */
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
        <h1>Žiadame Vás o vyplnenie dotazníka</h1>
    </div>
    <div class="email-body">
        <p>Vážený zákazník,</p>
        <p>Váš názor je pre nás veľmi dôležitý a preto by sme Vás chceli požiadať o vyplnenie tohto krátkeho dotazníka, ktorý nám pomôže skvalitniť naše služby.</p>

        <a href="https://docs.google.com/forms/d/e/1FAIpQLSeEytXYWvXSpUn6G8jWkpSR32SF9hwvAAu3Nx6oPpgZtJxC3g/viewform" class="button">Vyplniť dotazník</a>

        <p>V prípade akýchkoľvek otázok nás neváhajte kontaktovať.</p>

        <p>S pozdravom,<br>
            Tím Aima</p>
    </div>
    <div class="email-footer">
        <p>&copy; {{ date('Y') }} Aima. Všetky práva vyhradené.</p>
    </div>
</div>
</body>
</html>
