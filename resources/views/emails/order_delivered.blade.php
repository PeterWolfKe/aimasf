<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objednávka doručená na odberné miesto</title>
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
        .email-footer {
            text-align: center;
            font-size: 0.9em;
            color: #888;
        }
        .order-details {
            background: #f8f8f8;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .order-details th, .order-details td {
            padding: 8px 10px;
        }
        .order-details th {
            text-align: left;
            color: #555;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Vaša objednávka je pripravená na vyzdvihnutie!</h1>
    </div>
    <div class="email-body">
        <p>Vážený/á {{ $details['first_name'] }} {{ $details['last_name'] }},</p>
        <p>Vaša objednávka je pripravená na vyzdvihnutie na odbernom mieste.</p>
        <p>Objednávku si môžete vyzdvihnúť kedykoľvek počas otváracích hodín do 2 týždňov. Pri vyzdvihnutí objednávky budete potrebovať ID objednávky.</p>

        <h3>Prehľad objednávky</h3>
        <div class="order-details">
            <table>
                <tr>
                    <th>ID objednávky:</th>
                    <td>{{ $details['unique_order_id'] }}</td>
                </tr>
                <tr>
                    <th>Odberné miesto:</th>
                    <td>{{ $details['delivery_method'] }}</td>
                </tr>
                <tr>
                    <th>Adresa odberného miesta:</th>
                    <td>{{ $details['delivery_address'] }}</td>
                </tr>
            </table>
        </div>

        <h3>Zakúpené produkty</h3>
        <ul>
            @foreach ($details['products'] as $product)
                <li>{{ $product['name'] }} – {{ $product['quantity'] }} ks</li>
            @endforeach
        </ul>

        <p>Ak by ste mali akékoľvek otázky, neváhajte nás kontaktovať na support@aimasf.sk.</p>
        <p>Tešíme sa, že ste u nás nakúpili!</p>
    </div>
    <div class="email-footer">
        <p>&copy; {{ date('Y') }} Vaša spoločnosť aimasf. Všetky práva vyhradené.</p>
    </div>
</div>
</body>
</html>
