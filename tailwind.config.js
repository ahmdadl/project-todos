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
        extend: {
            fontFamily: {
                sans: ['Cairo', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                teal: colors.teal,
            },
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        cursor: ['disabled', 'hover'],
        backgroundColor: ['disabled', 'hover', 'focus', 'active', 'invalid'],
        borderColor: ['disabled', 'hover', 'focus', 'active', 'invalid', 'group-hover'],
        boxShadow: ['disabled', 'hover', 'focus', 'active', 'invalid'],
        outline: ['invalid', 'hover', 'focus', 'disabled'],
        textColor: ['invalid', 'hover', 'disabled', 'group-hover']
    },

    plugins: [
        require('@tailwindcss/ui'),
        require('tailwindcss-invalid-variant-plugin'),
    ],
};
