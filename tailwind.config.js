const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                quicksand: ['Quicksand', ...defaultTheme.fontFamily.serif],
            },
            maxWidth: {
                '1/2': '50%',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require("daisyui")],
};
