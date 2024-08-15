<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Editar Venta</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('ventas.update', $venta->id) }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="mb-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <ul class="list-disc ml-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            
            <div class="mb-4">
                <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->Nombre }}</option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Productos</label>
                @foreach ($productos as $producto)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="productos[]" id="producto_{{ $producto->id }}" value="{{ $producto->id }}" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" {{ in_array($producto->id, $venta->productos->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label for="producto_{{ $producto->id }}" class="ml-2 block text-sm leading-5 text-gray-900">{{ $producto->nombre }} - ${{ $producto->PV }}</label>
                        <input type="number" name="cantidad_{{ $producto->id }}" id="cantidad_{{ $producto->id }}" value="{{ $venta->productos->where('id', $producto->id)->first()->pivot->cantidad ?? 1 }}" min="1" class="ml-2 block w-24 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm cantidad-input">
                    </div>
                @endforeach
                @error('productos')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento</label>
                <input type="text" name="descuento" id="descuento" value="{{ old('descuento', $venta->descuento) }}" placeholder="Descuento aplicado" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('descuento')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="efectivo" class="block text-sm font-medium text-gray-700">Efectivo</label>
                <input type="text" name="efectivo" id="efectivo" value="{{ old('efectivo', $venta->efectivo) }}" placeholder="Monto en efectivo" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('efectivo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="cambio" class="block text-sm font-medium text-gray-700">Cambio</label>
                <input type="text" name="cambio" id="cambio" value="{{ old('cambio', $venta->cambio) }}" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="text" name="total" id="total" value="{{ old('total', $venta->total) }}" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="iva" class="block text-sm font-medium text-gray-700">IVA (16%)</label>
                <input type="text" name="iva" id="iva" value="{{ old('iva', $venta->iva) }}" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('ventas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-block">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-2 rounded inline-block">Actualizar Venta</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cantidadInputs = document.querySelectorAll('.cantidad-input');
            const checkboxInputs = document.querySelectorAll('input[type="checkbox"][name="productos[]"]');
            const descuentoInput = document.getElementById('descuento');
            const efectivoInput = document.getElementById('efectivo');
            const cambioInput = document.getElementById('cambio');
            const totalInput = document.getElementById('total');
            const ivaInput = document.getElementById('iva');

            function calculateTotals() {
                let subtotal = 0;
                checkboxInputs.forEach(checkbox => {
                    if (checkbox.checked) {
                        const productoId = checkbox.value;
                        const cantidad = parseFloat(document.getElementById(`cantidad_${productoId}`).value) || 0;
                        const precio = parseFloat(checkbox.nextElementSibling.textContent.split(' - $')[1]);
                        subtotal += cantidad * precio;
                    }
                });

                const descuento = parseFloat(descuentoInput.value) || 0;
                const total = subtotal - descuento;
                const iva = total * 0.16;

                totalInput.value = total.toFixed(2);
                ivaInput.value = iva.toFixed(2);
                calculateCambio();
            }

            function calculateCambio() {
                const total = parseFloat(totalInput.value) || 0;
                const efectivo = parseFloat(efectivoInput.value) || 0;
                const cambio = efectivo - total;

                cambioInput.value = cambio.toFixed(2);
            }

            checkboxInputs.forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotals);
            });

            cantidadInputs.forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            descuentoInput.addEventListener('input', () => {
                calculateTotals();
                calculateCambio();
            });

            efectivoInput.addEventListener('input', () => {
                calculateCambio();
            });

            calculateTotals(); // Calcula el total inicial al cargar la página
            calculateCambio(); // Calcula el cambio inicial al cargar la página
        });
    </script>
</x-app-layout>
