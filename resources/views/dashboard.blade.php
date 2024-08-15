<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Total Productos -->
                        <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold text-blue-800">Productos Existentes</h4>
                            <p class="text-2xl font-bold text-blue-900">{{ $totalProductos }}</p>
                        </div>

                        <!-- Total Vendidos -->
                        <div class="bg-green-100 p-4 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold text-green-800">Productos Vendidos</h4>
                            <p class="text-2xl font-bold text-green-900">{{ $totalVendidos }}</p>
                        </div>

                        <!-- Total Compras -->
                        <div class="bg-yellow-100 p-4 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold text-yellow-800">Productos en Compras</h4>
                            <p class="text-2xl font-bold text-yellow-900">{{ $totalCompras }}</p>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Ventas y Compras del Mes</h3>
                        <canvas id="ventasChart"></canvas>
                        <canvas id="comprasChart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctxVentas = document.getElementById('ventasChart').getContext('2d');
            const ctxCompras = document.getElementById('comprasChart').getContext('2d');

            const ventasData = @json($ventaData);
            const comprasData = @json($compraData);

            new Chart(ctxVentas, {
                type: 'line',
                data: {
                    labels: Object.keys(ventasData),
                    datasets: [{
                        label: 'Ventas',
                        data: Object.values(ventasData),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
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

            new Chart(ctxCompras, {
                type: 'line',
                data: {
                    labels: Object.keys(comprasData),
                    datasets: [{
                        label: 'Compras',
                        data: Object.values(comprasData),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
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
        });
    </script>
</x-app-layout>
