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
                    black: 'rgb(var(--brand-black-rgb) / <alpha-value>)',
                    teal: 'rgb(var(--brand-teal-rgb) / <alpha-value>)',
                    'teal-dark': 'rgb(var(--brand-teal-dark-rgb) / <alpha-value>)',
                    white: 'rgb(var(--brand-white-rgb) / <alpha-value>)',
                    gold: 'rgb(var(--brand-gold-rgb) / <alpha-value>)',
                    'gold-dark': 'rgb(var(--brand-gold-dark-rgb) / <alpha-value>)',
                },
            },
        },
    },

    plugins: [forms],
};
