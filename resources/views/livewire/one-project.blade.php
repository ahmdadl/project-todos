<div>
    <div
        class='group hover:bg-gray-300 transition duration-500 ease-linear relative bg-gray-700 shadow mb-4 rounded overflow-hidden'>
        <a class='appearance-none cursor-pointer' href='/projects/{{ $project->slug }}' class='text-lg'>
            <img class='w-full transition-transform duration-500 ease-in-out transform overflow-hidden hover:scale-110'
                src='{{ $user->profile_photo_url }}' />
            @if($project->completed)
                <div class='absolute top-0 left-0 bg-green-600 text-white uppercase p-1 rounded opacity-75'>
                    <i class='fas fa-check'></i>
                    completed
                </div>
            @endif
            @php // TODO fix completed not showing
             @endphp
            <div class='p-2 font-bold cursor-pointer'>
                <h3><a class='pt-1 text-teal-400 hover:text-teal-600 hover:underline group-hover:text-teal-700'
                        href='/projects/{{ $project->slug }}' class='text-lg'>{{ $project->name }}</a></h3>
                <p class='text-green-500'>${{ $project->cost }}</p>
                <p class='text-gray-300 group-hover:text-gray-800'>
                    <i class='fas fa-bookmark'></i>
                    {{ $project->category->title }}
                </p>
                <hr class='border border-gray-200 group-hover:border-gray-700 my-3' />
                @foreach(
                    $project->team as $team_user)
                    <img src="{{ $team_user->profile_photo_url }}"
                        class='h-10 w-10 rounded-full object-cover border-2 border-gray-300 inline group-hover:border-gray-800'
                        alt='{{ $team_user->name }} profile photo' title='{{ $team_user->name }}' />
                @endforeach
            </div>
        </a>
    </div>
</div>
