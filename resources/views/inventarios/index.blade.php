<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Inventarios</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="flex justify-end mb-4">
            <a href="{{ route('inventarios.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Agregar Inventario</a>
        </div>
        
        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                        <th class="border border-gray-200 px-2 py-2">Producto</th>
                        <th class="border border-gray-200 px-2 py-2">Categoría</th>
                        <th class="border border-gray-200 px-2 py-2">Fecha de Entrada</th>
                        <th class="border border-gray-200 px-2 py-2">Fecha de Salida</th>
                        <th class="border border-gray-200 px-2 py-2">Movimiento</th>
                        <th class="border border-gray-200 px-2 py-2">Cantidad</th>
                        <th class="border border-gray-200 px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-xs font-light">
                    @foreach($inventarios as $inventario)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="border border-gray-200 px-2 py-2">{{ $inventario->producto->nombre }}</td>
                            <td class="border border-gray-200 px-2 py-2">{{ $inventario->producto->categoria->nombre }}</td>
                            <td class="border border-gray-200 px-2 py-2">{{ $inventario->fecha_de_entrada }}</td>
                            <td class="border border-gray-200 px-2 py-2">{{ $inventario->fecha_de_salida }}</td>
                            <td class="border border-gray-200 px-2 py-2">{{ $inventario->movimiento }}</td>
                            <td class="border border-gray-200 px-2 py-2">{{ $inventario->cantidad }}</td>
                            <td class="py-2 px-2 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('inventarios.show', $inventario->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded inline-block">
                                        Mostrar
                                    </a>
                                    <a href="{{ route('inventarios.edit', $inventario->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded inline-block">
                                        Editar
                                    </a>
                                    <form action="{{ route('inventarios.destroy', $inventario->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded inline-block">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
