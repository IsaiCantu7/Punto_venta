{{-- resources/views/clientes/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Clientes</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <a href="{{ route('clientes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-3 inline-block">Crear Cliente</a>
        
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
                    <th class="border border-gray-200 px-2 py-3">Dirección</th>
                    <th class="border border-gray-200 px-2 py-3">RFC</th>
                    <th class="border border-gray-200 px-2 py-3">Razón Social</th>
                    <th class="border border-gray-200 px-2 py-3">Código Postal</th>
                    <th class="border border-gray-200 px-2 py-3">Regimen Fiscal</th>
                    <th class="border border-gray-200 px-2 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->id }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->Nombre }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->correo }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->telefono }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->Dirección }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->RFC }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->Razon_social }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->Codigo_postal }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cliente->Regimen_fiscal }}</td>
                    <td class="border border-gray-200 px-2 py-2">
                        <a href="{{ route('clientes.show', $cliente->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Mostrar</a>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="inline-block">
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
