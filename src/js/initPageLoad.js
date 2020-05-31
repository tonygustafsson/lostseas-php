window.addEventListener('load', () => {
    const initPageLoadEl = document.querySelector('.init-page-load');

    if (!initPageLoadEl) {
        return;
    }

    setTimeout(() => {
        initPageLoadEl.classList.remove('init-page-load--active');
    }, 2000);
});
