document.addEventListener("DOMContentLoaded", function() {
    const loader = document.getElementById('loader');
    loader.style.display = 'flex';

    function hideLoader() {
        loader.style.display = 'none';
    }

    window.onload = function() {
        hideLoader();
    };
});