<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <div class="w-1/4 bg-white dark:bg-gray-800 shadow-lg">
        <div class="p-4 text-lg font-semibold text-white">
    Punto de Venta
</div>

            <nav class="mt-2">
                <div class="flex flex-col space-y-4">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Inicio') }}
                    </x-nav-link>

                    <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                        {{ __('Productos') }}
                    </x-nav-link>

                    <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
                        {{ __('Categorías') }}
                    </x-nav-link>

                    <x-nav-link :href="route('proveedores.index')" :active="request()->routeIs('proveedores.*')">
                        {{ __('Proveedores') }}
                    </x-nav-link>

                    <x-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')">
                        {{ __('Clientes') }}
                    </x-nav-link>

                    <x-nav-link :href="route('vendedores.index')" :active="request()->routeIs('vendedores.*')">
                        {{ __('Vendedores') }}
                    </x-nav-link>


                    <x-nav-link :href="route('inventarios.index')" :active="request()->routeIs('inventarios.*')">
                        {{ __('Inventarios') }}
                    </x-nav-link>

                    <x-nav-link :href="route('compras.index')" :active="request()->routeIs('compras.*')">
                        {{ __('Compras') }}
                    </x-nav-link> 

                    
                    <x-nav-link :href="route('cotizaciones.index')" :active="request()->routeIs('cotizaciones.*')">
                        {{ __('Cotizacion') }}
                    </x-nav-link> 

                    <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')">
                        {{ __('Ventas') }}  
                    </x-nav-link>

                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="w-3/4 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white dark:bg-gray-800 shadow-lg p-4">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        @isset($header)
                            {{ $header }}
                        @else
                            Punto de Venta
                        @endisset
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow p-4">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
