<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Lista de Proveedores</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="flex justify-end mb-4">
            <a href="{{ route('proveedores.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Agregar Proveedor</a>
        </div>

        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="border border-gray-200 px-2 py-2">Nombre</th>
                        <th class="border border-gray-200 px-2 py-2">Nombre de Contacto</th>
                        <th class="border border-gray-200 px-2 py-2">Correo Electrónico</th>
                        <th class="border border-gray-200 px-2 py-2">Teléfono</th>
                        <th class="border border-gray-200 px-2 py-2">Fecha de Registro</th>
                        <th class="border border-gray-200 px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($proveedores as $proveedor)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="border border-gray-200 px-2 py-2">{{ $proveedor->nombre }}</td>
                        <td class="border border-gray-200 px-2 py-2">{{ $proveedor->nombre_contacto }}</td>
                        <td class="border border-gray-200 px-2 py-2">{{ $proveedor->correo }}</td>
                        <td class="border border-gray-200 px-2 py-2">{{ $proveedor->telefono }}</td>
                        <td class="border border-gray-200 px-2 py-2">{{ $proveedor->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('proveedores.show', $proveedor->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                                    Mostrar
                                </a>
                                <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">
                                    Editar
                                </a>
                                <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
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
