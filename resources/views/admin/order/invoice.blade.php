<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .invoice-header {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            text-align: left;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #e0e0e0;
        }
        .invoice-details > div {
            flex: 1;
        }
        .company-details {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-section {
            text-align: right;
            padding: 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #e0e0e0;
        }
        .total-section p {
            margin: 5px 0;
        }
        .total-section .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #3498db;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #e0e0e0;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .invoice-container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Invoice #{{ $order->id }}</h1>
        </div>

        <div class="invoice-details">
            <div>
                <h3>Bill To:</h3>
                <p>
                    <strong>{{ $order->address->name }}</strong><br>
                    {{ $order->address->address }}<br>
                    {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip }}<br>
                    Phone: {{ $order->address->phone }}
                </p>
            </div>
            <div class="company-details">
                <h3>SwiftCart E-Commerce</h3>
                <p>
                    123 E-commerce Street<br>
                    City, State 12345<br>
                    Phone: (123) 456-7890<br>
                    Email: info@swiftcart.com
                </p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Tax:</strong> ${{ number_format($order->tax, 2) }}</p>
            <p class="grand-total"><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>If you have any questions concerning this invoice, please contact our customer support.</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            if (window.opener) {
                window.print();
            }
        };
    </script>
</body>
</html>
