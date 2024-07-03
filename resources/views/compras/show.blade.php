<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalles de la Compra</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $compra->proveedor->nombre }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Productos</label>
                @foreach ($compra->productos as $producto)
                    <div class="flex items-center mb-2">
                        <p class="ml-2 block text-sm leading-5 text-gray-900">{{ $producto->nombre }} - ${{ $producto->pivot->precio_unitario }} x {{ $producto->pivot->cantidad }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                <label for="iva" class="block text-sm font-medium text-gray-700">IVA (16%)</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ number_format($iva, 2) }}</p>
            </div>

            <div class="mb-4">
                <label for="subtotal" class="block text-sm font-medium text-gray-700">Subtotal</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ number_format($subtotal, 2) }}</p>
            </div>

            <div class="mb-4">
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ number_format($total, 2) }}</p>
            </div>

            <div class="mb-4">
                <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ number_format($compra->descuento, 2) }}</p>
            </div>

            <div class="mb-4">
                <label for="efectivo" class="block text-sm font-medium text-gray-700">Efectivo</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ number_format($compra->efectivo, 2) }}</p>
            </div>

            <div class="mb-4">
                <label for="cambio" class="block text-sm font-medium text-gray-700">Cambio</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ number_format($compra->efectivo - $total, 2) }}</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('compras.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Volver</a>
            </div>
        </div>
    </div>
</x-app-layout>
