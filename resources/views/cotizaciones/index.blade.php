<x-app-layout>
    <x-slot name="header">
        <h1 class="my-4 text-2xl font-bold text-white">Cotizaciones</h1>
    </x-slot>

    <div class="container mx-auto px-4 py-2">
        <div class="flex justify-end mb-4">
            <a href="{{ route('cotizaciones.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-3 inline-block">Crear Cotización</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4" role="alert">
                <p>{{ $message }}</p>
            </div>
        @endif
    
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-200 px-2 py-3">Cliente</th>
                    <th class="border border-gray-200 px-2 py-3">Vendedor</th>
                    <th class="border border-gray-200 px-2 py-3">Fecha de Cotización</th>
                    <th class="border border-gray-200 px-2 py-3">Vigencia</th>
                    <th class="border border-gray-200 px-2 py-3">Subtotal</th>
                    <th class="border border-gray-200 px-2 py-3">IVA</th>
                    <th class="border border-gray-200 px-2 py-3">Total</th>
                    <th class="border border-gray-200 px-2 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cotizaciones as $cotizacion)
                <tr>
                    <td class="border border-gray-200 px-2 py-2">{{ $cotizacion->cliente->Nombre }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cotizacion->vendedor->nombre }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cotizacion->fecha_cot }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cotizacion->vigencia }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cotizacion->subtotal }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cotizacion->iva }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $cotizacion->total }}</td>
                    <td class="border border-gray-200 px-2 py-2">
                        <a href="{{ route('cotizaciones.reporte.pdf', $cotizacion->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded inline-block">
                            Descargar PDF
                        </a>
                        <a href="{{ route('cotizaciones.show', $cotizacion->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">Mostrar</a>
                        <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                        <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('¿Estás seguro de que quieres eliminar esta cotización?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $cotizaciones->links() }}
        </div>
    </div>
</x-app-layout>
