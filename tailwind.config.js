const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('@tailwindcss/forms');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './Modules/**/resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Cinzel', 'Cairo', ...defaultTheme.fontFamily.sans],
                cinzel: ['Cinzel', 'serif'],
                cairo: ['Cairo', 'sans-serif'],
            },
            colors: {
                brand: {
                    black: '#000000',
                    teal: '#144034',
                    'teal-dark': '#0f2d26',
                    white: '#FFFFFF',
                    gold: '#D3AE72',
                    'gold-dark': '#b8945c',
                },
            },
        },
    },

    plugins: [forms],
};
