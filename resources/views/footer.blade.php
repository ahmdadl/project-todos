<div class='px-2 py-5 bg-gray-900 dark:bg-blue-900 dark:border-t dark:border-gray-100 text-white'>
    <div class='grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-2'>
        @include('footer.social')
        <div class='text-center'>
            Copyright <a href="https://abo3adel.github.io/" target='_blank' class="text-yellow-400 text-lg whitespace-pre hover:font-bold"
                style="font-variant: small-caps">NinjaCoder</a>&copy; 2020
            {{ date('Y') > 2020 ? '- ' . date('Y') : '' }}.
            <br />
            <span class='inline-block'>All rights
                reserved</span>
        </div>
    </div>
</div>
