{{-- resources/views/vendedores/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalles del Vendedor</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-xl bg-white p-6 rounded-lg shadow-md">

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700"><span class="font-bold">Nombre:</span> {{ $vendedor->nombre }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700"><span class="font-bold">Correo:</span> {{ $vendedor->correo }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700"><span class="font-bold">Teléfono:</span> {{ $vendedor->telefono ?: 'No especificado' }}</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('vendedores.edit', $vendedor->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                <form action="{{ route('vendedores.destroy', $vendedor->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block ml-2">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
