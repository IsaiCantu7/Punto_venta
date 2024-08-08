<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cotización</title>
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
        <h1>Reporte de Cotización</h1>
    </div>

    <div class="section">
        <h2>Detalles de la Cotización</h2>
        <p><strong>ID Cotización:</strong> {{ $cotizacion->id }}</p>
        <p><strong>Fecha de Cotización:</strong> {{ $cotizacion->fecha_cot }}</p>
        <p><strong>Vigencia:</strong> {{ $cotizacion->vigencia }}</p>
        <p><strong>Comentarios:</strong> {{ $cotizacion->comentarios }}</p>
    </div>

    <div class="section">
        <h2>Información del Cliente</h2>
        <p><strong>Nombre:</strong> {{ $cliente->Nombre }}</p>
        <p><strong>Email:</strong> {{ $cliente->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
    </div>

    <div class="section">
        <h2>Información del Vendedor</h2>
        <p><strong>Nombre:</strong> {{ $vendedor->nombre }}</p>
        <p><strong>Email:</strong> {{ $vendedor->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $vendedor->telefono }}</p>
    </div>

    <div class="section">
        <h2>Productos Cotizados</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <!-- <th>Cantidad</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <!-- <td>{{ $producto->pivot->cantidad }}</td>                     -->
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
                    <td>${{ number_format($cotizacion->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <th>IVA (16%):</th>
                    <td>${{ number_format($cotizacion->iva, 2) }}</td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td>${{ number_format($cotizacion->total, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
