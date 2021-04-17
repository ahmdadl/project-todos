<link rel="stylesheet" href="{{ mix('css/app.css') }}">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="preload" as='style' onload="this.onload=null; this.rel='stylesheet'">

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.3/gh-fork-ribbon.min.css" />
<style>
.github-fork-ribbon.left-top:before {
    background-color: #233876;
}
</style>

<a target="_blank" class="github-fork-ribbon left-top fixed" href="https://github.com/abo3adel/project-todos" data-ribbon="Fork me on GitHub" title="Fork me on GitHub">Fork me on GitHub</a>