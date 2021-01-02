const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('@tailwindcss/ui/colors');
const { after } = require('lodash');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        themeVariants: ['dark', 'neon'],
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
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        cursor: ['disabled', 'hover'],
        backgroundColor: [
            'disabled',
            'hover',
            'focus',
            'active',
            'invalid',
            'dark',
        ],
        backgroundImage: ['disabled', 'dark', 'responsive'],
        borderColor: [
            'disabled',
            'hover',
            'focus',
            'active',
            'invalid',
            'group-hover',
            'dark',
        ],
        boxShadow: ['disabled', 'hover', 'focus', 'active', 'invalid', 'dark'],
        outline: ['invalid', 'hover', 'focus', 'disabled'],
        textColor: ['invalid', 'hover', 'disabled', 'group-hover', 'dark'],
        gradientColorStops: ['responsive', 'dark', 'hover', 'focus'],
    },

    plugins: [
        require('@tailwindcss/ui'),
        require('tailwindcss-invalid-variant-plugin'),
        require('tailwindcss-multi-theme'),
    ],
};
