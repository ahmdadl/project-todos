<div>
    <div
        class='group hover:bg-gray-300 transition duration-500 ease-linear relative bg-gray-700 shadow mb-4 rounded overflow-hidden'>
        <a class='appearance-none cursor-pointer' href='/projects/{{ $project->slug }}' class='text-lg'>
            <img class='w-full transition-transform duration-500 ease-in-out transform overflow-hidden hover:scale-110'
                src='{{ $project->img_path }}' />
            @if($project->completed)
                <div class='absolute top-0 left-0 bg-green-600 text-white uppercase p-1 opacity-75'>
                    <i class='fas fa-check'></i>
                    completed
                </div>
            @endif
            <div class='absolute top-0 right-0 bg-red-700 text-white px-2 font-semibold opacity-75'>
                {{ $project->todos_count ?? 0 }}
                <i class='fas fa-at'></i>
            </div>
            <div class='p-2 font-bold cursor-pointer'>
                <h3><a class='pt-1 text-teal-400 hover:text-teal-600 hover:underline group-hover:text-teal-700'
                        href='/projects/{{ $project->slug }}' class='text-lg'>{{ $project->name }}</a></h3>
                <p class='text-green-500'>${{ $project->cost }}</p>
                <p class='text-gray-300 group-hover:text-gray-800'>
                    <i class='fas fa-bookmark'></i>
                    {{ $project->category->title }}
                </p>
                <hr class='border border-gray-400 group-hover:border-gray-700 my-3' />
                @foreach(
                    $project->team as $team_user)
                    <img src="{{ $team_user->profile_photo_url }}"
                        class='h-10 w-10 rounded-full object-cover border-2 border-gray-300 inline group-hover:border-gray-800'
                        alt='{{ $team_user->name }} profile photo' title='{{ $team_user->name }}' />
                @endforeach
                <hr class='border border-gray-400 group-hover:border-gray-700 my-3' />
                <div class='grid grid-cols-2 sm:grid-cols-3 gap-1 sm:gap-0'>
                    <x-jet-button class='rounded-r-none' bg='blue' clear='1' icon='fas fa-edit'>Edit</x-jet-button>
                    <x-jet-button bg='red' :clear='1' rounded='0' icon='fas fa-trash-alt'
                        wire:click.prevent='destroy({{$index}})'>delete
                    </x-jet-button>
                    <x-jet-button class='rounded-l-none' bg='teal' clear='1' icon='fas fa-plus'>
                        user
                    </x-jet-button>
                </div>
            </div>
        </a>
    </div>
</div>
