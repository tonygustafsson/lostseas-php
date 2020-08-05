const logFilterClick = (e) => {
    e.preventDefault();

    const link = e.target;
    const baseUrl = document.getElementById('base_url').value;
    const logFilterEl = document.getElementById('log_filter');
    const url = `${baseUrl}/${logFilterEl.value}`;

    link.href = url;
    link.click();
};

window.addEventListener('inventory-log', () => {
    const link = document.getElementById('log_filter_trigger');

    link.addEventListener('click', logFilterClick);
});
