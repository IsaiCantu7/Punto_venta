<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Editar Compra</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('compras.update', $compra->id) }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="id_proveedor" class="block text-sm font-medium text-gray-700">Proveedor</label>
                <select name="id_proveedor" id="id_proveedor" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $compra->id_proveedor == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
                @error('id_proveedor')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Productos</label>
                @foreach ($productos as $producto)
                    @php
                        $productoEnCompra = $compra->productos->where('id', $producto->id)->first();
                        $cantidad = $productoEnCompra ? $productoEnCompra->pivot->cantidad : 1;
                    @endphp
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="productos[]" id="producto_{{ $producto->id }}" value="{{ $producto->id }}" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" {{ $productoEnCompra ? 'checked' : '' }}>
                        <label for="producto_{{ $producto->id }}" class="ml-2 block text-sm leading-5 text-gray-900">{{ $producto->nombre }} - ${{ $producto->PV }}</label>
                        <input type="number" name="cantidad_{{ $producto->id }}" id="cantidad_{{ $producto->id }}" value="{{ $cantidad }}" min="1" class="ml-2 block w-24 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm cantidad-input">
                        <input type="hidden" name="precio_{{ $producto->id }}" value="{{ $producto->PV }}">
                    </div>
                @endforeach
                @error('productos')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="iva" class="block text-sm font-medium text-gray-700">IVA (16%)</label>
                <input type="text" id="iva" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="subtotal" class="block text-sm font-medium text-gray-700">Subtotal</label>
                <input type="text" id="subtotal" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="text" id="total" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento</label>
                <input type="text" name="descuento" id="descuento" value="{{ old('descuento', $compra->descuento) }}" placeholder="Descuento aplicado" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('descuento')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="efectivo" class="block text-sm font-medium text-gray-700">Efectivo</label>
                <input type="text" name="efectivo" id="efectivo" value="{{ old('efectivo', $compra->efectivo) }}" placeholder="Monto en efectivo" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('efectivo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="cambio" class="block text-sm font-medium text-gray-700">Cambio</label>
                <input type="text" id="cambio" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <input type="hidden" name="cambio" id="cambio_hidden">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('compras.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-2 rounded inline-block">Actualizar Compra</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cantidadInputs = document.querySelectorAll('.cantidad-input');
            const checkboxInputs = document.querySelectorAll('input[type="checkbox"][name="productos[]"]');
            const ivaInput = document.getElementById('iva');
            const descuentoInput = document.getElementById('descuento');
            const subtotalInput = document.getElementById('subtotal');
            const totalInput = document.getElementById('total');
            const efectivoInput = document.getElementById('efectivo');
            const cambioInput = document.getElementById('cambio');
            const cambioHiddenInput = document.getElementById('cambio_hidden');

            function calculateTotals() {
                let total = 0;

                checkboxInputs.forEach((checkbox, index) => {
                    if (checkbox.checked) {
                        const productoId = checkbox.value;
                        const precio = parseFloat(document.querySelector(`input[name="precio_${productoId}"]`).value) || 0;
                        const cantidad = parseFloat(document.getElementById(`cantidad_${productoId}`).value) || 0;
                        total += precio * cantidad;
                    }
                });

                const iva = total * 0.16;
                const descuento = parseFloat(descuentoInput.value) || 0;
                const subtotal = total - iva;
                const totalFinal = subtotal + iva - descuento;

                totalInput.value = totalFinal.toFixed(2);
                ivaInput.value = iva.toFixed(2);
                subtotalInput.value = subtotal.toFixed(2);

                calculateCambio();
            }

            function calculateCambio() {
                const total = parseFloat(totalInput.value) || 0;
                const efectivo = parseFloat(efectivoInput.value) || 0;
                const cambio = efectivo - total;

                cambioInput.value = cambio.toFixed(2);
                cambioHiddenInput.value = cambio.toFixed(2);
            }

            checkboxInputs.forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotals);
            });

            cantidadInputs.forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            descuentoInput.addEventListener('input', calculateTotals);
            efectivoInput.addEventListener('input', calculateCambio);

            calculateTotals(); // Calcula los totales al cargar la página
        });
    </script>
</x-app-layout>
