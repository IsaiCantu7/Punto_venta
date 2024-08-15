<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Crear Cotización</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form method="POST" action="{{ route('cotizaciones.store') }}" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label for="id_cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
                <select name="id_cliente" id="id_cliente" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Seleccionar Cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('id_cliente') == $cliente->id ? 'selected' : '' }}>{{ $cliente->Nombre }}</option>
                    @endforeach
                </select>
                @error('id_cliente')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="id_vendedor" class="block text-sm font-medium text-gray-700">Vendedor</label>
                <select name="id_vendedor" id="id_vendedor" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Seleccionar Vendedor</option>
                    @foreach($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}" {{ old('id_vendedor') == $vendedor->id ? 'selected' : '' }}>{{ $vendedor->nombre }}</option>
                    @endforeach
                </select>
                @error('id_vendedor')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="fecha_cot" class="block text-sm font-medium text-gray-700">Fecha de Cotización</label>
                    <input type="date" name="fecha_cot" id="fecha_cot" value="{{ now()->toDateString() }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('fecha_cot')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="vigencia" class="block text-sm font-medium text-gray-700">Vigencia</label>
                    <input type="date" name="vigencia" id="vigencia" value="{{ old('vigencia', now()->addDays(5)->toDateString()) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('vigencia')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="comentarios" class="block text-sm font-medium text-gray-700">Comentarios</label>
                <textarea name="comentarios" id="comentarios" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('comentarios') }}</textarea>
                @error('comentarios')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Buscar Productos</label>
                <input type="text" id="producto_search" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Buscar productos...">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Productos</label>
                @foreach($productos as $producto)
                    <div class="producto-item flex items-center mb-2">
                        <input type="checkbox" name="products[]" value="{{ $producto->id }}" data-price="{{ $producto->PC }}" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                        <span class="ml-2 text-gray-700">{{ $producto->nombre }} - ${{ number_format($producto->PV, 2) }}</span>
                        <input type="number" name="cantidad[]" value="1" min="1" class="ml-2 w-16 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                @endforeach
                @error('products')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="mb-4">
                <label for="subtotal" class="block text-sm font-medium text-gray-700">Subtotal</label>
                <input type="text" name="subtotal" id="subtotal" value="{{ old('subtotal') }}" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="iva" class="block text-sm font-medium text-gray-700">Total IVA (16%)</label>
                <input type="text" name="iva" id="iva" value="{{ old('iva') }}" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="text" name="total" id="total" value="{{ old('total') }}" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('cotizaciones.index') }}" class="mr-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Crear Cotización</button>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener referencias a los elementos del DOM
        const productCheckboxes = document.querySelectorAll('input[name="products[]"]');
        const cantidadInputs = document.querySelectorAll('input[name="cantidad[]"]');
        const subtotalInput = document.getElementById('subtotal');
        const totalIvaInput = document.getElementById('iva');
        const totalInput = document.getElementById('total');

        // Función para calcular el subtotal y el total de IVA
        function calcularSubtotalYTotalIva() {
            let subtotal = 0;

            // Calcular subtotal sumando el precio de los productos seleccionados multiplicado por la cantidad
            productCheckboxes.forEach(function(checkbox, index) {
                if (checkbox.checked) {
                    const productPrice = parseFloat(checkbox.dataset.price);
                    const quantity = parseFloat(cantidadInputs[index].value) || 1; // Valor por defecto si la cantidad no está definida

                    subtotal += productPrice * quantity; // Multiplicación del precio por la cantidad
                }
            });

            // Calcular total de IVA (16%)
            const ivaRate = 0.16;
            const totalIva = subtotal * ivaRate;

            // Calcular total (subtotal + total de IVA)
            const total = subtotal + totalIva;

            // Actualizar valores en los inputs
            subtotalInput.value = subtotal.toFixed(2);
            totalIvaInput.value = totalIva.toFixed(2);
            totalInput.value = total.toFixed(2);
        }

        // Escuchar cambios en los checkboxes de productos y en las cantidades
        productCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', calcularSubtotalYTotalIva);
        });
        cantidadInputs.forEach(function(input) {
            input.addEventListener('input', calcularSubtotalYTotalIva);
        });

        // Calcular subtotal y total de IVA al cargar la página
        calcularSubtotalYTotalIva();
    });
</script>

<script>
    // Filtrar productos por nombre
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('producto_search');
    const productoItems = document.querySelectorAll('.producto-item');

    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.toLowerCase();

        productoItems.forEach(item => {
            const productoName = item.querySelector('span').textContent.toLowerCase();
            if (productoName.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
</x-app-layout>
