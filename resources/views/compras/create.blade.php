<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Agregar Compra</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('compras.store') }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label for="id_proveedor" class="block text-sm font-medium text-gray-700">Proveedor</label>
                <select name="id_proveedor" id="id_proveedor" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
                @error('id_proveedor')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Fecha_de_compra" class="block text-sm font-medium text-gray-700">Fecha de Compra</label>
                <input type="date" name="Fecha_de_compra" id="Fecha_de_compra" value="{{ old('Fecha_de_compra') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('Fecha_de_compra')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="buscador" class="block text-sm font-medium text-gray-700">Buscar Producto</label>
                <input type="text" id="buscador" placeholder="Buscar productos..." class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="productos" class="block text-sm font-medium text-gray-700">Productos</label>
                <div id="lista-productos">
                    @foreach ($productos as $producto)
                        <div class="flex items-center mb-2 producto-item">
                            <input type="checkbox" name="productos[{{ $producto->id }}][id]" value="{{ $producto->id }}" id="producto-{{ $producto->id }}" class="mr-2 producto-checkbox" onchange="toggleProduct(this, '{{ $producto->id }}')">
                            <label for="producto-{{ $producto->id }}" class="mr-2">{{ $producto->nombre }}</label>
                            <input type="number" name="productos[{{ $producto->id }}][cantidad]" value="0" class="cantidad-input mr-2 block w-20 px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" data-precio="{{ $producto->PV }}" data-id="{{ $producto->id }}" min="0">
                            <input type="number" step="0.01" name="productos[{{ $producto->id }}][precio]" value="{{ $producto->PV }}" placeholder="Precio" readonly class="block w-20 px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-100">
                        </div>
                    @endforeach
                </div>
                @error('productos')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.querySelector('form');

                    form.addEventListener('submit', function(event) {
                        const productos = document.querySelectorAll('.producto-item');
                        let selectedProducts = {};

                        productos.forEach(producto => {
                            const checkbox = producto.querySelector('.producto-checkbox');
                            const cantidadInput = producto.querySelector('.cantidad-input');

                            // Solo incluir productos seleccionados con cantidad mayor que 0
                            if (checkbox.checked && cantidadInput.value > 0) {
                                selectedProducts[checkbox.value] = {
                                    id: checkbox.value,
                                    cantidad: cantidadInput.value,
                                    precio: producto.querySelector('input[name*="precio"]').value
                                };
                            }
                        });

                        // Limpiar los inputs de productos
                        Object.keys(selectedProducts).forEach(key => {
                            document.querySelector(`input[name="productos[${key}][id]"]`).value = selectedProducts[key].id;
                            document.querySelector(`input[name="productos[${key}][cantidad]"]`).value = selectedProducts[key].cantidad;
                            document.querySelector(`input[name="productos[${key}][precio]"]`).value = selectedProducts[key].precio;
                        });

                        // Asegúrate de que no se envíen productos no seleccionados
                        const productosInputs = document.querySelectorAll('input[name^="productos"]');
                        productosInputs.forEach(input => {
                            if (!input.value && !input.name.includes('cantidad')) {
                                input.closest('.producto-item').remove();
                            }
                        });
                    });
                });
            </script>

            <div class="mb-4">
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="text" name="total" id="total" value="{{ old('total') }}" placeholder="Total de la compra" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                @error('total')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento</label>
                <input type="text" name="descuento" id="descuento" value="{{ old('descuento') }}" placeholder="Descuento aplicado" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('descuento')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('compras.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-2 rounded inline-block">Agregar Compra</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cantidadInputs = document.querySelectorAll('.cantidad-input');
            const totalInput = document.getElementById('total');
            const buscador = document.getElementById('buscador');
            const productos = document.querySelectorAll('.producto-item');

            function calculateTotal() {
                let total = 0;

                cantidadInputs.forEach(input => {
                    const checkbox = document.getElementById('producto-' + input.dataset.id);
                    if (checkbox.checked) {
                        const cantidad = parseFloat(input.value) || 0;
                        const precio = parseFloat(input.dataset.precio);
                        total += cantidad * precio;
                    }
                });

                totalInput.value = total.toFixed(2);
            }

            cantidadInputs.forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            document.querySelectorAll('.producto-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotal);
            });

            buscador.addEventListener('input', function() {
                const searchTerm = buscador.value.toLowerCase();
                productos.forEach(producto => {
                    const label = producto.querySelector('label').textContent.toLowerCase();
                    if (label.includes(searchTerm)) {
                        producto.style.display = 'flex';
                    } else {
                        producto.style.display = 'none';
                    }
                });
            });

            // Nueva función para manejar el estado de los productos
            window.toggleProduct = function(checkbox, id) {
                const cantidadInput = document.querySelector(`input[data-id="${id}"]`);
                if (!checkbox.checked) {
                    cantidadInput.value = 0; // Resetear cantidad si no está seleccionado
                }
            };
        });
    </script>
</x-app-layout>
