<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Compra</title>
    <style>
        /* Estilos CSS para el ticket */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: bold;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .products {
            margin-bottom: 20px;
        }
        .products table {
            width: 100%;
            border-collapse: collapse;
        }
        .products th, .products td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        .products th {
            background-color: #f0f0f0;
            text-align: left;
        }
        .totals {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ticket de Compra</h1>
        </div>

        <div class="info">
            <p><strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}</p>
            <p><strong>Fecha de Compra:</strong> {{ $compra->Fecha_de_compra }}</p>
        </div>

        <div class="products">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compra->productos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>${{ $producto->pivot->precio_unitario }}</td>
                            <td>{{ $producto->pivot->cantidad }}</td>
                            <td>${{ $producto->pivot->precio_unitario * $producto->pivot->cantidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <p><strong>Subtotal:</strong> ${{ number_format($subtotal, 2) }}</p>
            <p><strong>IVA (16%):</strong> ${{ number_format($iva, 2) }}</p>
            <p><strong>Total:</strong> ${{ number_format($total, 2) }}</p>
        </div>
    </div>
</body>
</html>
