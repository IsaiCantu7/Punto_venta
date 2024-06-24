<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Editar Movimiento de Producto</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('inventarios.update', $inventario->id) }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="producto_id" class="block text-sm font-medium text-gray-700">Producto</label>
                <select name="producto_id" id="producto_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ $inventario->producto_id == $producto->id ? 'selected' : '' }} data-categoria-id="{{ $producto->categoria_id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $inventario->producto->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="fecha_de_entrada" class="block text-sm font-medium text-gray-700">Fecha de Entrada</label>
                <input type="date" name="fecha_de_entrada" id="fecha_de_entrada" value="{{ $inventario->fecha_de_entrada }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="fecha_de_salida" class="block text-sm font-medium text-gray-700">Fecha de Salida</label>
                <input type="date" name="fecha_de_salida" id="fecha_de_salida" value="{{ $inventario->fecha_de_salida }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="movimiento" class="block text-sm font-medium text-gray-700">Movimiento</label>
                <input type="text" name="movimiento" id="movimiento" value="{{ $inventario->movimiento }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" value="{{ $inventario->cantidad }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('inventarios.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-2 rounded inline-block">Actualizar Movimiento</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('producto_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var categoriaId = selectedOption.getAttribute('data-categoria-id');
            
            var categoriaSelect = document.getElementById('categoria_id');
            categoriaSelect.value = categoriaId;
        });
    </script>
</x-app-layout>
