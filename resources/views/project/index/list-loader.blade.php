<div class='hidden' wire:loading.class.remove='hidden'>
    <div wire:ignore x-data>
        <div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 sm:gap-3 md:gap-5'>
            <template x-for='i in 10' :key='i * Math.random()'>
                <div class='w-full h-full'>
                    <svg role="img"  aria-labelledby="loading-aria" viewBox="0 0 305 254"
                        preserveAspectRatio="none">
                        <title>Loading...</title>
                        <rect x="0" y="0" width="100%" height="100%" clip-path="url(#clip-path)"
                            style='fill: url("#fill");'></rect>
                        <defs>
                            <clipPath id="clip-path">
                                <rect x="0" y="99" rx="0" ry="0" width="251" height="10" />
                                <circle cx="20" cy="178" r="20" />
                                <circle cx="60" cy="179" r="20" />
                                <rect x="0" y="216" rx="0" ry="0" width="55" height="18" />
                                <rect x="61" y="216" rx="0" ry="0" width="55" height="18" />
                                <rect x="121" y="216" rx="0" ry="0" width="55" height="18" />
                                <rect x="0" y="0" rx="0" ry="0" width="305" height="90" />
                                <rect x="0" y="114" rx="0" ry="0" width="83" height="15" />
                                <circle cx="100" cy="179" r="20" />
                                <circle cx="140" cy="179" r="20" />
                                <rect x="0" y="135" rx="0" ry="0" width="115" height="15" />
                                <rect x="181" y="216" rx="0" ry="0" width="55" height="18" />
                            </clipPath>
                            <linearGradient id="fill">
                                <stop offset="0.599964" stop-color="#545454" stop-opacity="1">
                                    <animate attributeName="offset" values="-2; -2; 1" keyTimes="0; 0.25; 1" dur="2s"
                                        repeatCount="indefinite"></animate>
                                </stop>
                                <stop offset="1.59996" stop-color="#2b2b2b" stop-opacity="1">
                                    <animate attributeName="offset" values="-1; -1; 2" keyTimes="0; 0.25; 1" dur="2s"
                                        repeatCount="indefinite"></animate>
                                </stop>
                                <stop offset="2.59996" stop-color="#545454" stop-opacity="1">
                                    <animate attributeName="offset" values="0; 0; 3" keyTimes="0; 0.25; 1" dur="2s"
                                        repeatCount="indefinite"></animate>
                                </stop>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </template>
        </div>
    </div>
</div>
