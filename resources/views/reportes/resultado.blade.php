<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Resultados del Reporte</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <h2 class="text-lg font-semibold mb-4 text-white">Reporte de Compras y Cotizaciones</h2>
        <p class=" text-white"><strong>Fecha de Inicio:</strong> {{ $fechaInicio }}</p>
        <p class=" text-white"><strong>Fecha de Fin:</strong> {{ $fechaFin }}</p>

        <!-- Grid de Gráficas -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <!-- Gráfico de Compras -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <canvas id="compraChart"></canvas>
            </div>

            <!-- Gráfico de Cotizaciones -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <canvas id="cotizacionChart"></canvas>
            </div>
        </div>

        <!-- Grid para productos más vendidos y detalles de ventas -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Productos Más Vendidos -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2">Productos Más Vendidos</h3>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Nombre del Producto</th>
                            <th class="py-2 px-4 border-b">Cantidad Vendida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosMasVendidos as $producto)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $producto['nombre'] }}</td>
                                <td class="py-2 px-4 border-b">{{ $producto['cantidad'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Detalles de Ventas -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2">Detalles de Ventas</h3>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID de Venta</th>
                            <th class="py-2 px-4 border-b">Fecha</th>
                            <th class="py-2 px-4 border-b">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detallesVentas as $venta)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $venta->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $venta->Fecha_de_venta }}</td>
                                <td class="py-2 px-4 border-b">{{ $venta->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <form action="{{ route('reporte.descargar') }}" method="POST">
        @csrf
        
        <input type="hidden" name="fechaInicio" value="{{ $fechaInicio }}">
        <input type="hidden" name="fechaFin" value="{{ $fechaFin }}">
        <input type="hidden" name="productosMasVendidos" value="{{ json_encode($productosMasVendidos) }}">
        <input type="hidden" name="detallesVentas" value="{{ json_encode($detallesVentas) }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Descargar PDF</button>
    </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const compraData = @json($compraData);
        const cotizacionData = @json($cotizacionData);

        // Gráfico de Compras
        const ctxCompra = document.getElementById('compraChart').getContext('2d');
        new Chart(ctxCompra, {
            type: 'line',
            data: {
                labels: compraData.map(item => item.date),
                datasets: [{
                    label: 'Total Compras',
                    data: compraData.map(item => item.total),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Cotizaciones
        const ctxCotizacion = document.getElementById('cotizacionChart').getContext('2d');
        new Chart(ctxCotizacion, {
            type: 'line',
            data: {
                labels: cotizacionData.map(item => item.date),
                datasets: [{
                    label: 'Total Cotizaciones',
                    data: cotizacionData.map(item => item.total),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Descargar PDF
        document.getElementById('downloadButton').addEventListener('click', function () {
            const compraChart = document.getElementById('compraChart');
            const cotizacionChart = document.getElementById('cotizacionChart');

            // Convertir gráficos a imagen
            const compraImage = compraChart.toDataURL('image/png');
            const cotizacionImage = cotizacionChart.toDataURL('image/png');

            // Crear un formulario para enviar las imágenes
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('reporte.descargar') }}';

            // Crear campos ocultos para las imágenes y otros datos
            const compraInput = document.createElement('input');
            compraInput.type = 'hidden';
            compraInput.name = 'compraImage';
            compraInput.value = compraImage;
            form.appendChild(compraInput);

            const cotizacionInput = document.createElement('input');
            cotizacionInput.type = 'hidden';
            cotizacionInput.name = 'cotizacionImage';
            cotizacionInput.value = cotizacionImage;
            form.appendChild(cotizacionInput);

            const fechaInicioInput = document.createElement('input');
            fechaInicioInput.type = 'hidden';
            fechaInicioInput.name = 'fechaInicio';
            fechaInicioInput.value = '{{ $fechaInicio }}';
            form.appendChild(fechaInicioInput);

            const fechaFinInput = document.createElement('input');
            fechaFinInput.type = 'hidden';
            fechaFinInput.name = 'fechaFin';
            fechaFinInput.value = '{{ $fechaFin }}';
            form.appendChild(fechaFinInput);

            const productosMasVendidosInput = document.createElement('input');
            productosMasVendidosInput.type = 'hidden';
            productosMasVendidosInput.name = 'productosMasVendidos';
            productosMasVendidosInput.value = JSON.stringify(@json($productosMasVendidos));
            form.appendChild(productosMasVendidosInput);

            const detallesVentasInput = document.createElement('input');
            detallesVentasInput.type = 'hidden';
            detallesVentasInput.name = 'detallesVentas';
            detallesVentasInput.value = JSON.stringify(@json($detallesVentas));
            form.appendChild(detallesVentasInput);

            // Agregar el formulario al cuerpo del documento y enviarlo
            document.body.appendChild(form);
            form.submit();
        });
    });
</script>

</x-app-layout>
