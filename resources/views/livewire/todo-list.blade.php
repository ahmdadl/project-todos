<div class='bg-gray-200 h-100'>
    <h2 class="bg-indigo-800 text-gray-100 w-100 py-3 px-4 mb-4">
        {{ $category->title }}
    </h2>
    @forelse($todos as $todo)
        <div class="w-3/4 mx-auto py-2 px-3 rounded shadow dark:bg-gray-200 mb-2 bg-gray-100">
            <p class='block w-100 font-bold'>
                <span
                    class="{{ $todo->done ? 'line-through text-green-500' : '' }}">
                    {{ $todo->body }}
                </span>
            </p>
        </div>
    @empty
        <div class="bg-orange-500 text-gray-300 py-2 px-4 w-3/4 mx-auto">
            No Todos Here, Add More
        </div>
    @endforelse
</div>
