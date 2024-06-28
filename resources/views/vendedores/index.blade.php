{{-- resources/views/vendedores/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Vendedores</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <a href="{{ route('vendedores.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-3 inline-block">Crear Vendedor</a>
        
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4" role="alert">
                <p>{{ $message }}</p>
            </div>
        @endif
    
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-200 px-2 py-3">ID</th>
                    <th class="border border-gray-200 px-2 py-3">Nombre</th>
                    <th class="border border-gray-200 px-2 py-3">Correo</th>
                    <th class="border border-gray-200 px-2 py-3">Teléfono</th>
                    <th class="border border-gray-200 px-2 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendedores as $vendedor)
                <tr>
                    <td class="border border-gray-200 px-2 py-2">{{ $vendedor->id }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $vendedor->nombre }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $vendedor->correo }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $vendedor->telefono }}</td>
                    <td class="border border-gray-200 px-2 py-2">
                        <a href="{{ route('vendedores.show', $vendedor->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Mostrar</a>
                        <a href="{{ route('vendedores.edit', $vendedor->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                        <form action="{{ route('vendedores.destroy', $vendedor->id) }}" method="POST" class="inline-block">
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
