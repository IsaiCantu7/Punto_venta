{{-- resources/views/categorias/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Categorías</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <a href="{{ route('categorias.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-3 inline-block">Crear Categoría</a>
        
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4" role="alert">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- Mostrar errores --}}
        @if ($error = Session::get('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4" role="alert">
                <p>{{ $error }}</p>
            </div>
        @endif
    
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-200 px-6 py-3">ID</th>
                    <th class="border border-gray-200 px-6 py-3">Nombre</th>
                    <th class="border border-gray-200 px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                <tr>
                    <td class="border border-gray-200 px-6 py-4">{{ $categoria->id }}</td>
                    <td class="border border-gray-200 px-6 py-4">{{ $categoria->nombre }}</td>
                    <td class="border border-gray-200 px-6 py-4">
                        <a href="{{ route('categorias.show', $categoria->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Mostrar</a>
                        <a href="{{ route('categorias.edit', $categoria->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
