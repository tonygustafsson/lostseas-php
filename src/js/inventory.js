const checkAll = (e) => {
    const checkbox = e.target;
    const selectType = checkbox.dataset.select;
    const isChecked = checkbox.checked;

    const correspondingCheckboxes = Array.from(document.querySelectorAll(`input[name='${selectType}[]']`));

    correspondingCheckboxes.forEach((box) => {
        box.checked = isChecked;
        const row = box.closest('tr');
        const color = isChecked ? '#e5f0f6' : 'transparent';

        row.style.backgroundColor = color;
    });
};

const initCheckAll = () => {
    const trigger = document.querySelector('.js-inventory-check-all');
    trigger.addEventListener('change', checkAll);
};

const changeRowBackgroundColor = (e) => {
    const checkbox = e.target;
    const isChecked = checkbox.checked;
    const row = checkbox.closest('tr');
    const color = isChecked ? '#e5f0f6' : 'transparent';

    row.style.backgroundColor = color;
};

const initRowBackgroundColor = () => {
    const selectType = 'crew';
    const checkboxes = Array.from(document.querySelectorAll(`input[name='${selectType}[]']`));

    checkboxes.forEach((box) => {
        box.addEventListener('change', changeRowBackgroundColor);
    });
};

const clickRow = (e) => {
    if (e.target.tagName === 'INPUT') {
        // Ignore click on checkboxes
        return;
    }

    const row = e.target.closest('tr');
    const checkbox = row.querySelector('input[type=checkbox]');
    const isChecked = checkbox.checked;
    const color = !isChecked ? '#e5f0f6' : 'transparent';

    row.style.backgroundColor = color;
    checkbox.checked = !isChecked;
};

const initRowClick = () => {
    const rows = Array.from(document.querySelectorAll('#crew_form tr'));

    rows.forEach((row) => {
        row.addEventListener('click', clickRow);
    });
};

window.addEventListener('inventory-crew', () => {
    initCheckAll();
    initRowBackgroundColor();
    initRowClick();
});
