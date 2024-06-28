{{-- resources/views/clientes/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalles del Cliente</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <p class="mt-1 text-lg text-gray-900">{{ $cliente->Nombre }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Correo</label>
                <p class="mt-1 text-lg text-gray-900">{{ $cliente->correo }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $cliente->telefono }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Dirección</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $cliente->Dirección }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">RFC</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $cliente->RFC }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Razón Social</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $cliente->Razon_social }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Código Postal</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $cliente->Codigo_postal }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Regimen Fiscal</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $cliente->Regimen_fiscal }}</p>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <a href="{{ route('clientes.edit', $cliente->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Editar Cliente</a>
                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="inline-block ml-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Eliminar Cliente</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
