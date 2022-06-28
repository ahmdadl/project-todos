<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data
    :class="{'theme-dark': $store.common.dark}">

<head>
    @include('layouts.head')

    @livewireStyles
</head>

<body class="font-sans antialiased">
    {{-- splash screen --}}
    <div id="splashScreen">
        <div style="position: relative">
            <div style="display: flex; justify-content: center; align-items: center;height: 100vh;">
                <div class="sk-cube-grid">
                    <div class="sk-cube sk-cube1"></div>
                    <div class="sk-cube sk-cube2"></div>
                    <div class="sk-cube sk-cube3"></div>
                    <div class="sk-cube sk-cube4"></div>
                    <div class="sk-cube sk-cube5"></div>
                    <div class="sk-cube sk-cube6"></div>
                    <div class="sk-cube sk-cube7"></div>
                    <div class="sk-cube sk-cube8"></div>
                    <div class="sk-cube sk-cube9"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- main content --}}
    <div
        class="min-h-screen bg-gradient-to-r from-gray-300 to-gray-400 dark:from-gray-900 dark:to-gray-900 dark:text-gray-100">
        @livewire('navigation-dropdown')

            <div class='mt-16'>

                <!-- Page Heading -->
                @isset($header)
                    <header class="mb-5 font-semibold text-white bg-indigo-600 shadow dark:bg-indigo-800">
                        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <div class='flex flex-col justify-between min-h-screen'>
                    <main class='sm:p-2 md:p-3'>
                        {{ $slot ?? '' }}
                        @yield('content', '')

                        <x-toast></x-toast>
                    </main>
                    @include('footer')
                </div>
            </div>
    </div>


    <a target="_blank" class="fixed github-fork-ribbon left-top" href="https://github.com/abo3adel/project-todos"
        data-ribbon="Fork me on GitHub" title="Fork me on GitHub">Fork me on GitHub</a>

    <script>
        window.onload = function () {
            var a = document.querySelector("#splashScreen");
            a && (a.classList.add("hideMe"), setTimeout(function () {
                a.style.display = "none"
            }, 1E3))
        };

    </script>

    <script src='/js/lazysizes.min.js' defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    @stack('modals')

    @livewireScripts

        @stack('scripts')
</body>

</html>
