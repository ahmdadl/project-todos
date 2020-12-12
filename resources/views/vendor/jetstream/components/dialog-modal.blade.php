@props(['id' => null, 'maxWidth' => null])

    <x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
        <div class="px-6 py-4">
            <div class="text-lg">
                {{ $title }}
            </div>

            <div class="mt-4">
                {{ $content }}
            </div>
        </div>

        @isset($footer)
            <div class="px-6 py-4 bg-gray-100 text-right">
                {{ $footer }}
            </div>
        @endisset
    </x-jet-modal>
