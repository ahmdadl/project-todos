@extends('layouts.app')

@section('title')
All Categories
@endsection

@section('content')
<div class='grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5'>
    @foreach($categories as $cat)
        <div class="min-w-0 p-4 text-white {{Arr::random(['bg-purple-600', 'bg-red-600', 'bg-blue-600', 'bg-orange-600', 'bg-yellow-600', 'bg-green-600'])}} rounded-lg shadow-xs m-2">
            <h4 class="mb-4 font-semibold">
                <a href='/categories/{{ $cat->slug }}' class='visited:text-white w-100 bg-transparent hover:border-gray-300 focus:shadow border-b-2 border-gray-700 transition-colors duration-500 cursor-pointer'>
                    {{ $cat->title }}
                    <span class='bg-gray-100 text-gray-600 hover:text-gray-800 rounded-full px-2'>
                        {{$cat->projects_count}}
                    </span>
                </a>
            </h4>
            <p class='text-gray-300'>
                {{ $cat->slug }}
            </p>
        </div>
    @endforeach
</div>
@endsection
