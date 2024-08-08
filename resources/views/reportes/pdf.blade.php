<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Compras y Cotizaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Compras y Cotizaciones</h1>
        <p><strong>Fecha de Inicio:</strong> {{ $fechaInicio }}</p>
        <p><strong>Fecha de Fin:</strong> {{ $fechaFin }}</p>
    </div>

    <div class="section">
        <h2>Productos Más Vendidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Cantidad Vendida</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productosMasVendidos as $producto)
                    <tr>
                        <td>{{ $producto['nombre'] }}</td>
                        <td>{{ $producto['cantidad'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Detalles de Ventas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID de Venta</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detallesVentas as $venta)
                    <tr>
                        <td>{{ $venta['id'] }}</td>
                        <td>{{ $venta['Fecha_de_venta'] }}</td>
                        <td>{{ $venta['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
