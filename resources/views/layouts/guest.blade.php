<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>    
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-800 text-gray-100">
        {{ $slot }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/spruce@2.x.x/dist/spruce.umd.js"></script>
</body>
<script>
    window.Spruce.store('common', {
        testMail(mail) {
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                .test(
                    mail
                );
        },
    });
</script>

</html>
