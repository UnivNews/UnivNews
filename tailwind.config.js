import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                navy: '#00081e',
                crimson: '#b71032',
                background: '#fcf8f9',
                surface: '#ffffff',
                'text-main': '#1b1b1c',
                'border-main': '#c5c6cf',
            },
            fontFamily: {
                sans: ['"Work Sans"', ...defaultTheme.fontFamily.sans],
                heading: ['Montserrat', ...defaultTheme.fontFamily.sans],
                serif: ['"Source Serif 4"', ...defaultTheme.fontFamily.serif],
            },
            borderRadius: {
                none: '0px',
                sm: '0px',
                DEFAULT: '0px',
                md: '0px',
                lg: '0px',
                xl: '0px',
                '2xl': '0px',
                '3xl': '0px',
            }
        },
    },

    plugins: [forms],
};
