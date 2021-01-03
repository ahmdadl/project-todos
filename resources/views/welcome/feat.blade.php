<div id='second' class='min-h-screen bg-gradient-to-r from-gray-300 to-gray-400 dark:from-blue-900 dark:to-gray-900 dark:text-gray-100'>
    <h1 class='text-6xl mx-auto text-center border-b border-gray-800 dark:border-gray-200 w-3/4'>
        Features
    </h1>
    <div class='pt-8 grid grid-cols-1 sm:grid-cols-2 sm:gap-2'>
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
                    <li :data-count="i.count" class='py-2 border-l-8 border-blue-700 dark:border-gray-600 px-4 mb-1'
                        :class='`text-${i.color}-700 dark:text-${i.color}-400`'>
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
        <div class='bg-gray-200 dark:bg-gray-700 dark:text-white shadow'>
            <h4 class='text-4xl text-white bg-blue-900 dark:bg-gray-800 pl-4'>
                Built for you
            </h4>
            <ul class='list-none capitalize font-semibold'>
                <li class='list-item px-4 py-2 hover:bg-green-700 hover:text-white transition duration-500 ease-linear'>
                    <i class='fas fa-check'></i>
                    Category System
                </li>
                <li class='list-item px-4 py-2 hover:bg-green-700 hover:text-white transition duration-500 ease-linear'>
                    <i class='fas fa-check'></i>
                        per Project team
                </li>
                <li class='list-item px-4 py-2 hover:bg-green-700 hover:text-white transition duration-500 ease-linear'>
                    <i class='fas fa-check'></i>
                        Unlimited Projects

                </li>
                <li class='list-item px-4 py-2 hover:bg-green-700 hover:text-white transition duration-500 ease-linear'>
                    <i class='fas fa-check'></i>
                        unlimited todos
                </li>
                <li class='list-item px-4 py-2 hover:bg-green-700 hover:text-white transition duration-500 ease-linear'>
                    <i class='fas fa-check'></i>
                        unlimited teams
                </li>
            </ul>
        </div>
    </div>
</div>
