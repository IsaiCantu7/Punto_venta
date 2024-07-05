<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalle del Movimiento de Producto</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Producto</label>
                <input type="text" value="{{ $inventario->producto->nombre }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Categoría</label>
                <input type="text" value="{{ $inventario->producto->categoria->nombre }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Fecha de Entrada</label>
                    <input type="date" value="{{ $inventario->fecha_de_entrada }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Fecha de Salida</label>
                    <input type="date" value="{{ $inventario->fecha_de_salida }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Motivo</label>
                <input type="text" value="{{ $inventario->motivo }}" class="mt-1 block
                w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Movimiento</label>
                <input type="text" value="{{ $inventario->movimiento }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" value="{{ $inventario->cantidad }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('inventarios.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Volver</a>
                <a href="{{ route('inventarios.edit', $inventario->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 ml-2 rounded inline-block">Editar</a>
                <form action="{{ route('inventarios.destroy', $inventario->id) }}" method="POST" class="ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
