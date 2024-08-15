<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Crear Movimiento de Producto</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('inventarios.store') }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label for="producto_buscador" class="block text-sm font-medium text-gray-700">Buscar Producto</label>
                <input type="text" id="producto_buscador" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Buscar producto...">
                <select name="producto_id" id="producto_id" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="">Selecciona un producto</option>
                </select>
            </div>

            <input type="hidden" name="categoria_id" id="categoria_id">

            <div class="mb-4">
                <label for="fecha_de_entrada" class="block text-sm font-medium text-gray-700">Fecha de Entrada</label>
                <input type="date" name="fecha_de_entrada" id="fecha_de_entrada" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>


            <div class="mb-4">
                <label for="fecha_de_salida" class="block text-sm font-medium text-gray-700">Fecha de Salida</label>
                <input type="date" name="fecha_de_salida" id="fecha_de_salida" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo</label>
                <input type="text" name="motivo" id="motivo" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="movimiento" class="block text-sm font-medium text-gray-700">Movimiento</label>
                <select name="movimiento" id="movimiento" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="">Selecciona un movimiento</option>
                    <option value="entry">Entrada</option>
                    <option value="exit">Salida</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" value="1" min="1" name="cantidad" id="cantidad" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('inventarios.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-2 rounded inline-block">Crear Movimiento</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const movimientoSelect = document.getElementById('movimiento');
            const fechaEntrada = document.getElementById('fecha_de_entrada');
            const fechaSalida = document.getElementById('fecha_de_salida');

            function toggleFechaCampos() {
                if (movimientoSelect.value === 'entry') {
                    fechaSalida.disabled = true;
                    fechaEntrada.disabled = false;
                } else if (movimientoSelect.value === 'exit') {
                    fechaEntrada.disabled = true;
                    fechaSalida.disabled = false;
                } else {
                    fechaEntrada.disabled = false;
                    fechaSalida.disabled = false;
                }
            }

            // Inicializar el estado de los campos de fecha
            toggleFechaCampos();

            // Escuchar cambios en el select de movimiento
            movimientoSelect.addEventListener('change', toggleFechaCampos);

            document.getElementById('producto_buscador').addEventListener('input', function() {
                var filter = this.value.toLowerCase();
                var select = document.getElementById('producto_id');
                select.innerHTML = ''; // Limpiar el select antes de agregar opciones

                if (filter.length > 0) {
                    @foreach($productos as $producto)
                        if ("{{ $producto->nombre }}".toLowerCase().includes(filter)) {
                            var option = document.createElement('option');
                            option.value = "{{ $producto->id }}";
                            option.text = "{{ $producto->nombre }}";
                            option.setAttribute('data-categoria-id', "{{ $producto->categoria_id }}");
                            select.appendChild(option);
                        }
                    @endforeach
                }
            });

            // Sincronizar la selección de categoría cuando se selecciona un producto
            document.getElementById('producto_id').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var categoriaId = selectedOption.getAttribute('data-categoria-id');
                document.getElementById('categoria_id').value = categoriaId;
            });
        });
    </script>
</x-app-layout>
