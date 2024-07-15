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
                <label for="Fecha_de_compra" class="block text-sm font-medium text-gray-700">Fecha de Compra</label>
                <input type="date" name="Fecha_de_compra" id="Fecha_de_compra" value="{{ old('Fecha_de_compra', $compra->Fecha_de_compra) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('Fecha_de_compra')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="productos" class="block text-sm font-medium text-gray-700">Productos</label>
                @foreach ($productos as $producto)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="productos[{{ $producto->id }}][id]" value="{{ $producto->id }}" id="producto-{{ $producto->id }}" class="mr-2 producto-checkbox" {{ $compra->productos->contains($producto->id) ? 'checked' : '' }}>
                        <label for="producto-{{ $producto->id }}" class="mr-2">{{ $producto->nombre }}</label>
                        <input type="number" name="productos[{{ $producto->id }}][cantidad]" placeholder="Cantidad" value="{{ old('productos.' . $producto->id . '.cantidad', $compra->productos->find($producto->id)->pivot->cantidad ?? '') }}" class="cantidad-input mr-2 block w-20 px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" data-precio="{{ $producto->PV }}" data-id="{{ $producto->id }}">
                        <input type="number" step="0.01" name="productos[{{ $producto->id }}][precio]" value="{{ $producto->PV }}" placeholder="Precio" readonly class="block w-20 px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-100">
                    </div>
                @endforeach
                @error('productos')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="text" name="total" id="total" value="{{ old('total', $compra->total) }}" placeholder="Total de la compra" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                @error('total')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento</label>
                <input type="text" name="descuento" id="descuento" value="{{ old('descuento', $compra->descuento) }}" placeholder="Descuento aplicado" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('descuento')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
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
            const totalInput = document.getElementById('total');
            
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

            // Calcular total al cargar la página
            calculateTotal();
        });
    </script>
</x-app-layout>
