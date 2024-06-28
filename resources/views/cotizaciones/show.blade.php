<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalles de la Cotización</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Cliente: {{ $cotizacion->cliente->Nombre }}</p>
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Vendedor: {{ $cotizacion->vendedor->nombre }}</p>
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Fecha de Cotización: {{ $cotizacion->fecha_cot }}</p>
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Vigencia: {{ $cotizacion->vigencia }}</p>
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Comentarios:</p>
                <p>{{ $cotizacion->comentarios ?: 'Sin comentarios' }}</p>
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Productos:</p>
                <ul class="list-disc ml-6">
                    @foreach($cotizacion->productos as $producto)
                        <li>{{ $producto->nombre }} - ${{ number_format($producto->PC, 2) }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Subtotal: ${{ number_format($cotizacion->subtotal, 2) }}</p>
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Total IVA (16%): ${{ number_format($cotizacion->iva, 2) }}</p>
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Total: ${{ number_format($cotizacion->total, 2) }}</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('cotizaciones.index') }}" class="mr-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Regresar</a>
            </div>
        </div>
    </div>
</x-app-layout>
