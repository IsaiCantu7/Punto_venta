{{-- resources/views/categorias/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Editar Categoría</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ $categoria->nombre }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Actualizar Categoría</button>
            </div>
        </form>
    </div>
</x-app-layout>
