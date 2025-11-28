import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // kita kontrol via class .dark
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
                display: ['Poppins', 'sans-serif'],
            },
            colors: {
                // gunakan format rgb(var(--token) / <alpha-value>) agar bisa transparansi
                bg: 'rgb(var(--bg) / <alpha-value>)',
                surface: 'rgb(var(--surface) / <alpha-value>)',
                text: 'rgb(var(--text) / <alpha-value>)',
                muted: 'rgb(var(--muted) / <alpha-value>)',
                border: 'rgb(var(--border) / <alpha-value>)',
                accent: 'rgb(var(--accent) / <alpha-value>)',
                'accent-contrast': 'rgb(var(--accent-contrast) / <alpha-value>)',
                'accent-soft': 'rgb(var(--accent-soft) / <alpha-value>)',
            },
            borderRadius: {
                lg2: '1rem',
            },
            boxShadow: {
                soft: '0 6px 18px rgba(0,0,0,0.45)',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
