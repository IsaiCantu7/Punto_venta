<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalles del Proveedor</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $proveedor->nombre }}</p>
            </div>

            <div class="mb-4">
                <label for="nombre_contacto" class="block text-sm font-medium text-gray-700">Nombre de Contacto</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $proveedor->nombre_contacto }}</p>
            </div>

            <div class="mb-4">
                <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $proveedor->correo }}</p>
            </div>

            <div class="mb-4">
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $proveedor->telefono }}</p>
            </div>

            <div class="mb-4">
                <label for="fecha_registro" class="block text-sm font-medium text-gray-700">Fecha de Registro</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $proveedor->created_at->format('d/m/Y H:i:s') }}</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                    Editar
                </a>
                <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="transform hover:text-red-500 hover:scale-110">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
