<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Crear Producto</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('productos.store') }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="PV" class="block text-sm font-medium text-gray-700">Precio Venta</label>
                    <input type="number" step="0.01" name="PV" id="PV" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <div class="mb-4">
                    <label for="PC" class="block text-sm font-medium text-gray-700">Precio Compra</label>
                    <input type="number" step="0.01" name="PC" id="PC" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="Fecha_de_compra" class="block text-sm font-medium text-gray-700">Fecha de Compra</label>
                    <input type="date" name="Fecha_de_compra" id="Fecha_de_compra" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <div class="mb-4">
                    <label for="Color(es)" class="block text-sm font-medium text-gray-700">Color(es)</label>
                    <input type="text" name="Color(es)" id="Color(es)" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div class="mb-4">
                <label for="descripcion_corta" class="block text-sm font-medium text-gray-700">Descripción Corta</label>
                <textarea name="descripcion_corta" id="descripcion_corta" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="mb-4">
                <label for="descripcion_larga" class="block text-sm font-medium text-gray-700">Descripción Larga</label>
                <textarea name="descripcion_larga" id="descripcion_larga" rows="5" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Guardar Producto</button>
            </div>
        </form>
    </div>
</x-app-layout>
