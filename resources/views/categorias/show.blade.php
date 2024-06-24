{{-- resources/views/categorias/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Mostrar Categoría</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-3xl bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <p class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $categoria->nombre }}</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('categorias.edit', $categoria) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
