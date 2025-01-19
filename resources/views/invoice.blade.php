<html lang="sk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktúra - A4</title>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 2cm;
            }
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
        }

        h1, h2, h3 {
            margin-bottom: 10px;
            color: #2d2d2d;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table td {
            background-color: #f9f9f9;
        }

        .total {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-size: 0.85rem;
            text-align: center;
            color: #777;
        }

        .footer p {
            margin: 5px 0;
        }

    </style>
</head>
<body>
<div class="container">
    <!-- Company Header -->
    <header class="text-center">
        <h1>{{ $company_name }}</h1>
        <p>{{ $company_address }}</p>
        <p>{{ $company_city_postcode }}</p>
        <p>Telefón: {{ $company_phone }}</p>
    </header>

    <!-- Invoice Details -->
    <section>
        <div class="flex">
            <div>
                <h2 class="font-semibold">FAKTÚRA</h2>
                <p>Faktúra č. {{ $invoice_number }}</p>
                <p>Dátum: {{ $invoice_date }}</p>
            </div>
            <div class="text-right">
                <h2 class="font-semibold">PRÍJEMCA:</h2>
                <p>{{ $customer_name }}</p>
                <p>{{ $customer_email }}</p>
                <p>{{ $customer_address }}</p>
                <p>{{ $customer_postal_code }} {{ $customer_city }}</p>
                <p>Telefón: {{ $customer_phone }}</p>
            </div>
        </div>
    </section>

    <!-- Delivery Method -->
    <section class="mt-8">
        <h3 class="font-semibold">DODACIA ADRESA:</h3>
        <p>{{ $customer_name }}</p>
        <p>{{ $customer_address }}</p>
        <p>{{ $customer_postal_code }} {{ $customer_city }}</p>
        <p>Telefón: {{ $customer_phone }}</p>
        <h3 class="font-semibold">DODACÍ SPÔSOB:</h3>
        <p>{{ $delivery_method }}</p>
    </section>

    <!-- Products Table -->
    <section class="mt-8">
        <table class="table">
            <thead>
            <tr>
                <th>MNOŽSTVO</th>
                <th>POPIS</th>
                <th>CENA</th>
                <th>SPOLU</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ $product['name'] }} ({{ $product['size'] }})</td>
                    <td>{{ number_format($product['price'], 2) }} €</td>
                    <td>{{ number_format($product['quantity'] * $product['price'], 2) }} €</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    <!-- Total and Payment -->
    <section class="mt-8 text-right">
        <div class="flex justify-between">
            <span class="font-semibold">SLEVA KÓD:</span>
            <span>{{ $discount_code ?: 'Žiadny' }}</span>
        </div>
        <div class="flex justify-between total">
            <span>SPOLU NA ÚHRADU:</span>
            <span>{{ number_format($total_amount, 2) }} €</span>
        </div>
    </section>

    <footer class="footer">
        <p>Všetky šeky vystaviť v prospech spoločnosti {{ $company_name }}</p>
        <p>Ak máte akékoľvek otázky ohľadom tejto faktúry, kontaktujte nás na {{ $company_phone }} alebo {{ $company_email }}.</p>
        <p>Ďakujeme, že využívate naše služby!</p>
    </footer>
</div>
</body>
</html>
