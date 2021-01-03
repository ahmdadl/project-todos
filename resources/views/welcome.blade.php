<x-guest-layout>
    <!-- hero section -->
    <div class="min-h-screen text-left bg-blue-900 dark:bg-gray-900 pt-16 px-2 text-white">
        <div class='sm:px-2 md:px-4 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-3'>
            <div>
                <h1 class="text-6xl font-semibold leading-none">
                    Bring all your team together
                </h1>
                <h5 class="mt-6 text-xl font-light antialiased">
                    Never forget a project feature again and do not stress your team
                </h5>
                {{-- <button
                    class="mt-6 px-8 py-4 rounded-full font-normal tracking-wide bg-gradient-to-b from-blue-600 to-blue-700 text-white outline-none focus:outline-none hover:shadow-lg hover:from-blue-700 transition duration-200 ease-in-out">
                    Download for Free
                </button> --}}
            </div>
            <div class='hidden md:block'>
                <span class='float-right -m-12'>
                    <x-jet-application-logo w='300' h='300'></x-jet-application-logo>
                </span>
            </div>
        </div>
    </div>
    {{-- <div class="mt-12 lg:mt-32 lg:ml-20 text-left">
        <button type="button"
            class="flex items-center justify-center w-12 h-12 rounded-full bg-cool-gray-100 text-gray-800 animate-bounce hover:text-gray-900 hover:bg-cool-gray-50 transition duration-300 ease-in-out cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </button>
    </div> --}}
</x-guest-layout>
