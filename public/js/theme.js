// Theme Switcher
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    
    // Load saved theme from localStorage
    const savedTheme = localStorage.getItem('theme') || 'modern';
    if (savedTheme === 'classic') {
        body.classList.add('classic-theme');
    }
    
    // Toggle theme on button click
    themeToggle.addEventListener('click', function() {
        body.classList.toggle('classic-theme');
        
        // Save theme preference
        const newTheme = body.classList.contains('classic-theme') ? 'classic' : 'modern';
        localStorage.setItem('theme', newTheme);
        
        // Optional: Add a nice animation
        this.style.transform = 'rotate(180deg)';
        setTimeout(() => {
            this.style.transform = '';
        }, 300);
    });
});
