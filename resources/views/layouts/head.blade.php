<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#3062a9">
<meta name="theme-color" content="#ffffff">
<meta name="keywords" content="laravel, livewire, laravel liverwire, laravel 8, laravel jetstream, jetstream, alpineJs, todo, project todos, project features, team">
<meta name="description" content="just trying laravel jetstream in a new project">
<meta name="author" content="Ahmed Adel">

<title>
    @isset($title)
        {{ $title }}
    @else
        @yield('title', env('APP_NAME'))
    @endisset
</title>

@include('splashscreen')

<link rel="stylesheet" href="{{ mix('css/app.css') }}">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="preload" as='style'
    onload="this.onload=null; this.rel='stylesheet'">

<script>
    function prefersDark() {
        return JSON.parse(localStorage.getItem('dark-theme')) || (!!window.matchMedia && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)
    }
    if (prefersDark()) {
        document.documentElement.classList.add('theme-dark')
    } else {
        document.documentElement.classList.remove('theme-dark')
    }

</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.3/gh-fork-ribbon.min.css" rel="preload"
    as='style' onload="this.onload=null; this.rel='stylesheet'">

<style>
    .github-fork-ribbon.left-top:before {
        background-color: #233876;
    }
</style>