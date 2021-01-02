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

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">