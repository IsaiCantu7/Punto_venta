<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Editar Producto</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('productos.update', $producto->id) }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ $producto->nombre }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="mb-4">
                <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Selecciona una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" >{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="PV" class="block text-sm font-medium text-gray-700">Precio Venta</label>
                    <input type="number" step="0.01" name="PV" id="PV" value="{{ $producto->PV }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </div>

                <div class="mb-4">
                    <label for="PC" class="block text-sm font-medium text-gray-700">Precio Compra</label>
                    <input type="number" step="0.01" name="PC" id="PC" value="{{ $producto->PC }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="Fecha_de_compra" class="block text-sm font-medium text-gray-700">Fecha de Compra</label>
                    <input type="date" name="Fecha_de_compra" id="Fecha_de_compra" value="{{ $producto->Fecha_de_compra }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </div>

                <div class="mb-4">
                    <label for="Color(es)" class="block text-sm font-medium text-gray-700">Color(es)</label>
                    <input type="text" name="Color(es)" id="Color(es)" value="{{ $producto->{'Color(es)'} }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </div>
            </div>

            <div class="mb-4">
                <label for="descripcion_corta" class="block text-sm font-medium text-gray-700">Descripción Corta</label>
                <textarea name="descripcion_corta" id="descripcion_corta" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>{{ $producto->descripcion_corta }}</textarea>
            </div>

            <div class="mb-4">
                <label for="descripcion_larga" class="block text-sm font-medium text-gray-700">Descripción Larga</label>
                <textarea name="descripcion_larga" id="descripcion_larga" rows="5" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>{{ $producto->descripcion_larga }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('productos.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        // Lógica para rellenar automáticamente la categoría del producto
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el valor actual de la categoría del producto
            var categoriaId = '{{ $producto->categoria_id }}';

            // Selecionar el elemento select de categoría
            var categoriaSelect = document.getElementById('categoria_id');

            // Iterar sobre las opciones y seleccionar la categoría correspondiente
            for (var i = 0; i < categoriaSelect.options.length; i++) {
                if (categoriaSelect.options[i].value == categoriaId) {
                    categoriaSelect.options[i].selected = true;
                    break;
                }
            }
        });
    </script>
</x-app-layout>
