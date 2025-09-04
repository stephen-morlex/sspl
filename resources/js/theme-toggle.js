document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.querySelector('html');
    
    // Check for saved theme preference or respect OS preference
    const savedTheme = localStorage.getItem('theme');
    const osPreference = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    const initialTheme = savedTheme || osPreference;
    
    // Apply initial theme
    html.setAttribute('data-theme', initialTheme);
    document.body.setAttribute('data-theme', initialTheme);
    
    // Toggle theme function
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
});