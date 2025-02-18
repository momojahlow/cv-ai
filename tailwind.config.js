import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    safelist: [
        'text-primary',
    'text-secondary',
    'text-danger',
    'text-success',
    'text-warning',
    'text-info',
    'text-light',
    'text-dark',

    // Background colors
    'bg-primary',
    'bg-secondary',
    'bg-danger',
    'bg-success',
    'bg-warning',
    'bg-info',
    'bg-light',
    'bg-dark',

    // Border colors
    'border-primary',
    'border-secondary',
    'border-danger',
    'border-success',
    'border-warning',
    'border-info',
    'border-light',
    'border-dark',

    // Border opacity
    'border-opacity-30',

    // Other classes
    'hover:text-pink-600',
    'hover:bg-pink-600',
    'hover:border-pink-600',
    'hover:underline',
    'hover:shadow-lg',
      ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#2b8d96',
                secondary: '#16a34a',
                danger: '#e3342f',
                success: '#38a169',
                warning: '#f6993f',
                info: '#6cb2eb',
                light: '#f4f4f4',
                dark: '#2d3748',
            },
        },
    },

    plugins: [forms, typography],
};
