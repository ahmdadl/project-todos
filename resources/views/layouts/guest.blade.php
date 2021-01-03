<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data
    :class="{'theme-dark': $store.common.dark}">

<head>
    @include('layouts.head')

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
</head>

<body class="font-sans antialiased">
    <div
        class="min-h-screen bg-gradient-to-r from-gray-300 to-gray-400 dark:from-blue-900 dark:to-gray-900 dark:text-gray-100">

        <nav class="border-b border-blue-900 dark:border-gray-900 bg-blue-900 dark:bg-gray-900 text-white">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="@auth /projects @else / @endauth">
                                <x-jet-application-mark class="block h-9 w-auto" />
                            </a>
                        </div>
                    </div>
                    <x-theme-toggler></x-theme-toggler>
                    <div class='font-semibold flex justify-items-center'>
                        <div class='mt-3 sm:mt-4'>
                            @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class='py-1 px-3 border border-red-600 bg-red-600 hover:bg-red-900 inline-block transition duration-500 ease-in-out rounded'
                                        href="{{ route('logout') }}" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                    class='py-1 px-3 border text-gray-300 border-gray-300 hover:text-gray-900 hover:bg-gray-300 inline-block transition duration-500 ease-in-out rounded'>
                                    {{ __('Login') }}
                                </a>
                                <a href="{{ route('register') }}"
                                    class='hidden sm:inline-block py-1 px-3 border border-green-600 bg-green-600 hover:bg-green-800 transition duration-500 ease-in-out rounded'>
                                    {{ __('Register') }}
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div>
            {{ $slot }}
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/spruce@2.x.x/dist/spruce.umd.js"></script>
</body>
<script>
    window.Spruce.store('common', {
        testMail(mail) {
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                .test(
                    mail
                );
        },
        dark: JSON.parse(localStorage.getItem('dark-theme')) || (!!window.matchMedia && window
            .matchMedia('(prefers-color-scheme: dark)').matches),
        toggleDark() {
            this.dark = !this.dark;
            localStorage.setItem('dark-theme', this.dark);
        },
    });

</script>

</html>
