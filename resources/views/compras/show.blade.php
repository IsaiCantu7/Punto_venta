<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalles de Compra</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="proveedor" class="block text-sm font-medium text-gray-700">Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" value="{{ $compra->proveedor->nombre ?? 'No disponible' }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="mb-4">
                <label for="Fecha_de_compra" class="block text-sm font-medium text-gray-700">Fecha de Compra</label>
                <input type="text" name="Fecha_de_compra" id="Fecha_de_compra" value="{{ $compra->Fecha_de_compra }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="mb-4">
                <label for="productos" class="block text-sm font-medium text-gray-700">Productos</label>
                <ul class="mt-1">
                    @foreach ($compra->productos as $producto)
                        <li class="mb-1">
                            {{ $producto->nombre }} - Cantidad: {{ $producto->pivot->cantidad }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-4">
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="text" name="total" id="total" value="{{ $compra->total }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="mb-4">
                <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento</label>
                <input type="text" name="descuento" id="descuento" value="{{ $compra->descuento }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('compras.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Regresar</a>
            </div>
        </div>
    </div>
</x-app-layout>
