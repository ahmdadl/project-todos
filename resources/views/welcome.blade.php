<x-guest-layout>
    <div class="min-h-screen text-left bg-blue-900 dark:bg-gray-900 pt-16 px-2 text-white">
        <div class='sm:px-2 md:px-4 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-3'>
            <div>
                <h1 class="text-6xl font-semibold leading-none">
                    Bring all your team together
                </h1>
                <h5 class="mt-6 text-xl font-light antialiased">
                    Never forget a project feature again and do not stress your team
                </h5>
                <div class='mt-10'>
                    <a href='#second' type="button"
                        class="flex items-center justify-center w-12 h-12 rounded-full bg-cool-gray-100 text-gray-800 animate-bounce hover:text-gray-900 hover:bg-cool-gray-50 transition duration-300 ease-in-out cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class='hidden md:block'>
                <span class='float-right -m-12'>
                    <x-jet-application-logo w='300' h='300'></x-jet-application-logo>
                </span>
            </div>
        </div>
    </div>
    <div id='second' class='min-h-screen bg-gray-200'>
        <h1 class='text-6xl mx-auto text-center border-b border-gray-800 w-3/4'>
            Features
        </h1>
        <div class='pt-8 grid grid-cols-1 sm:grid-cols-2'>
            <div class='bg-gray-200 dark:bg-gray-700 dark:text-white shadow'>
                <h4 class='text-4xl text-white bg-blue-900 dark:bg-gray-800 pl-4'>
                    Statics
                </h4>
                <ul class='list-none font-bold' x-data="{
                    arr: [
                        {
                            count: 100,
                            icon: 'user',
                            txt: 'Users Registerd',
                            color: 'blue'
                        },
                        {
                            count: 200,
                            icon: 'book',
                            txt: 'Projects Created',
                            color: 'indigo'
                        },
                        {
                            count: 200,
                            icon: 'users',
                            txt: 'Project Team Members',
                            color: 'teal'
                        },
                        {
                            count: 300,
                            icon: 'at',
                            txt: 'Todos Created',
                            color: 'red'
                        },
                        {
                            count: 250,
                            icon: 'check',
                            txt: 'Todos is Completed',
                            color: 'green'
                        },
                    ],
                }">
                    <template x-for="i in arr" :key='i.count + i.icon'>
                        <li :data-count="i.count" class='py-2 border-l-8 border-blue-700 dark:border-gray-600 px-4 mb-1' :class='`text-${i.color}-700 dark:text-${i.color}-400`'>
                            <i :class="'fas fa-' + i.icon"></i>
                            <span x-data="{from: 0, num: 400}" x-init="() => {
                                num = parseInt($el.parentElement.getAttribute('data-count'));
                                const ival = setInterval(() => {
                                    if (from >= num-1) clearInterval(ival);
                                    from++;
                                }, 15);
                            }" x-text='from + "+"'>
                            </span>
                            <span x-text='i.txt'></span>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</x-guest-layout>
