<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'SIMPEG') }}</title>
        
        <!-- Fonts - Preload untuk performa -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,600,700&display=swap" rel="stylesheet" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50" style="font-family: 'Inter', system-ui, sans-serif;">
        <div class="flex h-screen overflow-hidden">
            @include('layouts.navigation')
            
            <div class="flex-1 flex flex-col ml-64 overflow-y-auto">
                @if (isset($header))
                    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
                        <div class="max-w-7xl mx-auto py-4 px-6">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                
                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
                
                <footer class="bg-white border-t border-gray-200 py-4">
                    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between text-sm text-gray-600">
                        <span><strong>SIMPEG</strong> - Sistem Informasi Manajemen Pegawai</span>
                        <span>© {{ date('Y') }}</span>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
