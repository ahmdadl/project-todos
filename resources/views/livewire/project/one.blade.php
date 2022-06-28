<div>
    <div class='relative mb-4 overflow-hidden transition duration-500 ease-linear bg-gray-300 rounded shadow-lg dark:bg-gray-700'>
        <a aria-label="{{ $project->title }}" title="go to {{ $project->title }}" class='appearance-none cursor-pointer' href='/projects/{{ $project->slug }}' class='text-lg'>
            <img class='w-full overflow-hidden transition-transform duration-500 ease-in-out transform hover:scale-110 lazyload' style='min-height: 11rem'
                data-src='{{ $project->img_path }}' alt="projecct image" width="413" height="200" />
            @if($project->completed)
                <div class='absolute top-0 left-0 p-1 text-white uppercase bg-green-600 opacity-75'>
                    <i class='fas fa-check'></i>
                    completed
                </div>
            @endif
            <div class='absolute top-0 right-0 px-2 font-semibold text-white bg-red-700 opacity-75'>
                {{ $project->todos_count ?? 0 }}
                <i class='fas fa-at'></i>
            </div>
            <div class='p-2 font-bold cursor-pointer'>
                <p><a class='pt-1 text-teal-600 dark:text-teal-400 hover:text-teal-800 hover:underline'
                        href='/projects/{{ $project->slug }}' class='text-lg'>{{ $project->name }}</a></p>
                <p class='text-green-500'>${{ $project->cost }}</p>
                <p class='text-gray-700 dark:text-gray-300'>
                    <i class='fas fa-bookmark'></i>
                    {{ $project->category->title }}
                </p>
                <hr class='my-3 border border-gray-600 dark:border-gray-300' wire:ignore />
                <div class='px-2'>
                    @foreach(
                        $project->team as $team_user)
                        <img data-src="{{ $team_user->profile_photo_url }}"
                            class='inline object-cover w-10 h-10 -m-2 border-2 border-gray-300 rounded-full lazyload'
                            alt='{{ $team_user->name }} profile photo' title='{{ $team_user->name }}' />
                    @endforeach
                </div>
                <hr class='my-3 border border-gray-600 dark:border-gray-300' wire:ignore />
                <div class='grid grid-cols-2 gap-1 text-center sm:grid-cols-4 sm:gap-0'>
                    <x-jet-button class='rounded-r-none' bg='blue' clear='1' icon='fas fa-edit'
                        wire:click.prevent='edit'>
                        <span class='hidden overflow-hidden overflow-clip md:block'>
                            Edit
                        </span>
                    </x-jet-button>
                    @if($project->completed)
                        <x-jet-button bg='orange' class='' :clear='1' rounded='0' icon='fas fa-times'
                            wire:click.prevent='toggleCompleted'>
                            <span class='hidden overflow-hidden overflow-clip md:block'>complete</span>
                        </x-jet-button>
                    @else
                        <x-jet-button bg='green' class='' :clear='1' rounded='0' icon='fas fa-check'
                            wire:click.prevent='toggleCompleted'>
                            <span class='hidden overflow-hidden overflow-clip md:block'>complete</span>
                        </x-jet-button>
                    @endif
                    <x-jet-button bg='red' :clear='1' rounded='0' icon='fas fa-trash-alt'
                        wire:click.prevent='toggleModal'>
                        <span class='hidden overflow-hidden overflow-clip md:block'>delete</span>
                    </x-jet-button>
                    <x-jet-button class='rounded-l-none' bg='teal' clear='1' icon='fas fa-plus'
                        wire:click.prevent='toggleTeamModal'>
                        <span class='hidden overflow-hidden overflow-clip md:block'>user</span>
                    </x-jet-button>
                </div>
            </div>
        </a>
    </div>
    <x-jet-confirmation-modal wire:model.lazy='openModal' wire:ignore>
        <x-slot name='title'>
            <h1 class='text-lg font-semibold'>
                Confirim Delete
            </h1>
        </x-slot>

        <x-slot name='content'>
            <h3 class='text-lg text-red-500 capitalize'>
                <strong>are you sure want to delete</strong> <span
                    class='text-sm text-white'>{{ $project->name }}</span>
            </h3>
        </x-slot>

        <x-slot name='footer'>
            <x-jet-button bg='red' clear='1' wire:click.prevent='destroy' icon='fas fa-trash-alt'>
                delete
            </x-jet-button>
            <x-jet-button bg='orange' wire:click.prevent='toggleModal' icon='fas fa-times'>
                cancel
            </x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-dialog-modal wire:model.defer='teamModal'>
        <x-slot name='title'>
            Add User
        </x-slot>

        <x-slot name='content'>
            <x-jet-form-section submit='addUserToTeam'>
                <x-slot name='title'>
                    {{-- add new project to list --}}
                </x-slot>
                <x-slot name='description'>
                    add new user to this project team
                </x-slot>

                <x-slot name='form'>
                    <div>
                        <x-jet-input type='email' name='teamUserMail' wire:model.defer='teamUserMail' class='w-full'
                            placeholder='User Mail' required />
                        <x-jet-input-error for='teamUserMail' class='pt-1'></x-jet-input-error>
                    </div>

                    <x-slot name='actions'>
                        <x-jet-button type='submit' bg='green' icon='fas fa-plus' class='mx-1'>add
                        </x-jet-button>
                        <x-jet-button type='reset' wire:click.prevent='toggleTeamModal' bg='orange' clear='1'
                            icon='fas fa-times'>
                            reset</x-jet-button>
                    </x-slot>
                </x-slot>
            </x-jet-form-section>
        </x-slot>
    </x-jet-dialog-modal>
</div>
