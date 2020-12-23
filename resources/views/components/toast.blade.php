<div x-data>
    <span x-on:notify-success.window="$store.toast.success($event.detail.message)" x-cloak></span>
    <span x-on:notify-warn.window="$store.toast.warn($event.detail.message)" x-cloak></span>
    <span x-on:notify-error.window="$store.toast.error($event.detail.message)" x-cloak></span>
    <span x-on:notify-info.window="$store.toast.info($event.detail.message)" x-cloak></span>
</div>

<div x-data class='fixed bottom-0 right-0' wire:ignore>
    <template x-for='(t, inx) in $store.toast.arr'>
        <div class='toast cursor-pointer text-white opacity-100' :class="'toast-' + t.type"
            x-on:click='$store.toast.remove(inx)' x-show="t.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="opacity-100 transform scale-100">
            <template x-if="t.type === 'default'">
                <div class="text-blue-500 rounded-full bg-white mr-3">
                    <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-info" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z" />
                        <circle cx="8" cy="4.5" r="1" />
                    </svg>
                </div>
            </template>
            <template x-if="t.type === 'info'">
                <div class="text-blue-500 rounded-full bg-white mr-3">
                    <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-info" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z" />
                        <circle cx="8" cy="4.5" r="1" />
                    </svg>
                </div>
            </template>
            <template x-if="t.type === 'success'">
                <div class="text-green-500 rounded-full bg-white mr-3">
                    <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                    </svg>
                </div>
            </template>
            <template x-if="t.type === 'warn'">
                <div class="text-orange-500 rounded-full bg-white mr-3">
                    <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-exclamation" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                    </svg>
                </div>
            </template>
            <template x-if="t.type === 'danger'">
                <div class="text-red-500 rounded-full bg-white mr-3">
                    <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z" />
                        <path fill-rule="evenodd"
                            d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z" />
                    </svg>
                </div>
            </template>
            <span class='text-white max-w-xs' x-text='t.message'></span>
        </div>
    </template>
</div>
