<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')

    @livewireStyles

    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-800 text-gray-100">
        @livewire('navigation-dropdown')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-indigo-700 text-white font-semibold shadow mb-5">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class='sm:p-2 md:p-3'>
                {{ $slot ?? '' }}
                @yield('content', '')

                <x-toast></x-toast>
            </main>
    </div>

    @stack('modals')

    @livewireScripts

    @stack('scripts')
</body>

</html>
