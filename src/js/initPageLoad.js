window.addEventListener('load', () => {
    const initPageLoadEl = document.querySelector('.init-page-load');

    if (!initPageLoadEl) {
        return;
    }

    initPageLoadEl.classList.add('init-page-load--active');

    setTimeout(() => {
        initPageLoadEl.classList.remove('init-page-load--active');
    }, 2000);
});
