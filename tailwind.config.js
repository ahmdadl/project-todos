const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('@tailwindcss/ui/colors');
const { after } = require('lodash');

module.exports = {
    purge: {
        enable: true,
        mode: 'all',
        preserveHtmlElements: false,
        content: [
            './vendor/laravel/jetstream/**/*.blade.php',
            './storage/framework/views/*.php',
            './resources/views/*.blade.php',
            './resources/views/**/*.blade.php',
            './node_modules/@fortawesome/fontawesome-free/css/fontawesome.min.css'
        ],
        options: {
            safelist: {
                // standard: ['bg-blue-500', 'bg-red-500'],
                // deep: [/bg-green-500/],
            }
        }
    },

    theme: {
        themeVariants: ['dark'],
        extend: {
            fontFamily: {
                sans: [
                    'Roboto',
                    'Cairo',
                    '-apple-system',
                    'BlinkMacSystemFont',
                    'Segoe UI',
                    ...defaultTheme.fontFamily.sans,
                ],
            },
            colors: {
                teal: colors.teal,
            },
        },
    },

    variants: {
        animation: ['responsive', 'hover'],
        backgroundColor: [
            'disabled',
            'hover',
            'focus',
            'active',
            'invalid',
            'dark', 'dark:hover', 'dark:focus',
        ],
        backgroundImage: ['disabled', 'dark', 'dark:hover', 'dark:focus', 'responsive'],
        borderColor: [
            'disabled',
            'hover',
            'focus',
            'active',
            'invalid',
            'group-hover',
            'dark', 'dark:hover', 'dark:focus',
        ],
        boxShadow: ['disabled', 'hover', 'focus', 'active', 'invalid', 'dark', 'dark:hover', 'dark:focus'],
        cursor: ['disabled', 'hover'],
        gradientColorStops: ['responsive', 'dark', 'dark:hover', 'dark:focus', 'hover', 'focus'],
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        outline: ['invalid', 'hover', 'focus', 'disabled'],
        textColor: ['invalid', 'hover', 'disabled', 'group-hover', 'dark', 'dark:hover', 'dark:focus'],
    },

    plugins: [
        require('@tailwindcss/ui'),
        require('tailwindcss-invalid-variant-plugin'),
        require('tailwindcss-multi-theme'),
    ],
};
