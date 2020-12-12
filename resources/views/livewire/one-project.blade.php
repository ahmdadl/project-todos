<div>
    <div class='relative bg-gray-700 shadow mb-4 rounded'>
        <img class='border border-white w-100' src='{{ $user->profile_photo_url }}' />
        @if($project->completed)
            <div class='absolute top-0 left-0 bg-green-600 text-white uppercase p-1 rounded opacity-75'>
                <i class='fas fa-check'></i>
                completed
            </div>
        @endif
        <div class='p-2 font-bold'>
            <h3><a class='text-teal-400 hover:text-teal-500 hover:underline' href='/projects/{{ $project->slug }}'
                    class='text-lg'>{{ $project->name }}</a></h3>
            <p class='text-green-500'>${{ $project->cost }}</p>
            <p class='text-gray-300'>
                <i class='fas fa-bookmark'></i>
                {{ $project->category->title }}
            </p>
            <hr class='bg-gray-700' />

        </div>
    </div>
</div>
