<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .totals {
            text-align: right;
        }
        .totals th, .totals td {
            border: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Compra</h1>
    </div>

    <div class="section">
        <h2>Detalles de la Compra</h2>
        <p><strong>ID Compra:</strong> {{ $compra->id }}</p>
        <p><strong>Fecha de Compra:</strong> {{ $compra->Fecha_de_compra }}</p>
        <p><strong>Proveedor:</strong> {{ $proveedor->nombre }}</p>
        <p><strong>Descuento:</strong> ${{ number_format($compra->descuento, 2) }}</p>
    </div>

    <div class="section">
        <h2>Productos Comprados</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->pivot->cantidad }}</td>
                        <td>${{ number_format($producto->pivot->precio, 2) }}</td>
                        <td>${{ number_format($producto->pivot->cantidad * $producto->pivot->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section totals">
        <table>
            <tbody>
                <tr>
                    <th>Subtotal:</th>
                    <td>${{ number_format($compra->productos->sum(function($producto) {
                        return $producto->pivot->cantidad * $producto->pivot->precio;
                    }), 2) }}</td>
                </tr>
                <tr>
                    <th>IVA (16%):</th>
                    <td>${{ number_format(($compra->productos->sum(function($producto) {
                        return $producto->pivot->cantidad * $producto->pivot->precio;
                    }) * 0.16), 2) }}</td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td>${{ number_format($compra->total, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
