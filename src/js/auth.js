document.addEventListener('DOMContentLoaded', function (e) {
    const showAuthBtn = document.getElementById('MediaManager-show-auth-form'),
        authContainer = document.getElementById('MediaManager-auth-container'),
        close = document.getElementById('MediaManager-auth-close');
    
    showAuthBtn.addEventListener('click', () => {
        authContainer.classList.add('show');        
        showAuthBtn.parentElement.classList.add('hide');
    });

    close.addEventListener('click', () => {
        authContainer.classList.remove('show');
        showAuthBtn.parentElement.classList.remove('hide');
    });
});