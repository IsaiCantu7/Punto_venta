<div class="container">
    <div class="header">
        <h1>Ticket de Venta</h1>
    </div>

    <div class="info">
        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
        <p><strong>Fecha de Venta:</strong> {{ $venta->Fecha_de_venta }}</p>
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
                @foreach ($venta->productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>${{ $producto->pivot->precio_unitario }}</td>
                        <td>{{ $producto->pivot->cantidad }}</td>
                        <td>${{ number_format($producto->pivot->precio_unitario * $producto->pivot->cantidad, 2) }}</td>
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
