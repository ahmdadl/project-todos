<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>
    @isset($title)
        {{ $title }}
    @else
        @yield('title', env('APP_NAME'))
    @endisset
</title>

<link rel="stylesheet" href="{{ mix('css/app.css') }}">
