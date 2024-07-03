<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Detalles de la Forma de Pago</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="flex justify-start mb-4">
            <a href="{{ route('forma_pago.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-3 inline-block">Volver a la lista</a>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <h2 class="text-gray-700 text-lg font-bold mb-2">ID:</h2>
                <p class="text-gray-700">{{ $formaDePago->id }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-gray-700 text-lg font-bold mb-2">Tipo de Forma de Pago:</h2>
                <p class="text-gray-700">{{ $formaDePago->tipo }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-gray-700 text-lg font-bold mb-2">Fecha de Creación:</h2>
                <p class="text-gray-700">{{ $formaDePago->created_at }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-gray-700 text-lg font-bold mb-2">Última Actualización:</h2>
                <p class="text-gray-700">{{ $formaDePago->updated_at }}</p>
            </div>

            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('forma_pago.edit', $formaDePago->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Editar</a>
                <form action="{{ route('forma_pago.destroy', $formaDePago->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
