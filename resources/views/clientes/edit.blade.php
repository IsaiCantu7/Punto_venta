{{-- resources/views/clientes/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Editar Cliente</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="max-w-xl bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="Nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="Nombre" id="Nombre" value="{{ $cliente->Nombre }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                <input type="email" name="correo" id="correo" value="{{ $cliente->correo }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" value="{{ $cliente->telefono }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <div class="mb-4">
                    <label for="Dirección" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <input type="text" name="Dirección" id="Dirección" value="{{ $cliente->Dirección }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="RFC" class="block text-sm font-medium text-gray-700">RFC</label>
                    <input type="text" name="RFC" id="RFC" value="{{ $cliente->RFC }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="Razon_social" class="block text-sm font-medium text-gray-700">Razón Social</label>
                    <input type="text" name="Razon_social" id="Razon_social" value="{{ $cliente->Razon_social }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="Codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                    <input type="text" name="Codigo_postal" id="Codigo_postal" value="{{ $cliente->Codigo_postal }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="Regimen_fiscal" class="block text-sm font-medium text-gray-700">Regimen Fiscal</label>
                    <input type="text" name="Regimen_fiscal" id="Regimen_fiscal" value="{{ $cliente->Regimen_fiscal }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Actualizar Cliente</button>
            </div>
        </form>
    </div>
</x-app-layout>
