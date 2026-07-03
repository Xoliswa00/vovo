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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                heading: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                body: ['"IBM Plex Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    DEFAULT: '#0B1F3D',
                    deep: '#081633',
                    surface: '#112A52',
                },
                accent: {
                    DEFAULT: '#2E93BD',
                    light: '#3CAAD2',
                    dark: '#24799C',
                },
                taupe: '#8C7A65',
                muted: '#5C6B7E',
            },
        },
    },

    plugins: [forms],
};
