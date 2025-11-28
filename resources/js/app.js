import './bootstrap';

// Theme toggle functionality
const root = document.documentElement;

// Load saved theme preference or default to dark
const saved = localStorage.getItem('theme');
if (saved === 'light') {
    root.classList.remove('dark');
} else {
    root.classList.add('dark'); // default to dark
    localStorage.setItem('theme', 'dark');
}

// Theme toggle button handler
const btn = document.getElementById('themeToggle');
if (btn) {
    btn.addEventListener('click', () => {
        const isDark = root.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    });
}

// Initialize theme on page load (in case script runs before DOM)
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        root.classList.remove('dark');
    } else {
        root.classList.add('dark');
    }
});
