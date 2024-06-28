<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Productos</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <a href="{{ route('productos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-3 inline-block">Crear Producto</a>
        
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4" role="alert">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4" role="alert">
                <p>{{ $message }}</p>
            </div>
        @endif
    
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-200 px-2 py-3">ID</th>
                    <th class="border border-gray-200 px-2 py-3">Nombre</th>
                    <th class="border border-gray-200 px-2 py-3">Categoría</th>
                    <th class="border border-gray-200 px-2 py-3">Precio Venta</th>
                    <th class="border border-gray-200 px-2 py-3">Precio Compra</th>
                    <th class="border border-gray-200 px-2 py-2">Fecha de Compra</th>
                    <th class="border border-gray-200 px-2 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <td class="border border-gray-200 px-2 py-2">{{ $producto->id }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $producto->nombre }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $producto->categoria->nombre }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $producto->PV }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $producto->PC }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $producto->Fecha_de_compra }}</td>
                    <td class="border border-gray-200 px-2 py-2">
                        <a href="{{ route('productos.show', $producto->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Mostrar</a>
                        <a href="{{ route('productos.edit', $producto->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                        
                        {{-- Formulario de eliminación --}}
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            
                            {{-- Botón de eliminación con confirmación --}}
                            <button type="submit" onclick="return confirm('¿Estás seguro que deseas eliminar este producto?');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
