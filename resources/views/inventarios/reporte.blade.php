<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #343a40;
            color: white;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #e9ecef;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Inventario</h1>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Fecha de Entrada</th>
                    <th>Fecha de Salida</th>
                    <th>Motivo</th>
                    <th>Movimiento</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $inventario->producto->nombre }}</td>
                    <td>{{ $inventario->categoria->nombre }}</td>
                    <td>{{ $inventario->fecha_de_entrada }}</td>
                    <td>{{ $inventario->fecha_de_salida }}</td>
                    <td>{{ $inventario->motivo }}</td>
                    <td>
                        @if($inventario->movimiento === 'entry')
                            Entrada
                        @elseif($inventario->movimiento === 'exit')
                            Salida
                        @else
                            {{ $inventario->movimiento }}
                        @endif
                    </td>
                    <td>{{ $inventario->cantidad }}</td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <p>Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
