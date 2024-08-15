<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalle de la Venta</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cliente</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $venta->cliente->Nombre }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Productos</label>
                @foreach ($venta->productos as $producto)
                    <div class="flex items-center mb-2">
                        <p class="block text-sm leading-5 text-gray-900">{{ $producto->nombre }} - ${{ $producto->pivot->precio_unitario }}</p>
                        <p class="ml-2 block w-24 px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $producto->pivot->cantidad }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Descuento</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">${{ $venta->descuento }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Efectivo</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">${{ $venta->efectivo }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cambio</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">${{ $venta->cambio }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Total</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">${{ $venta->precio_total }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">IVA (16%)</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">${{ $venta->iva }}</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('ventas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Volver</a>
            </div>
        </div>
    </div>
</x-app-layout>
