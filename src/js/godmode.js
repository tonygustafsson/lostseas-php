const changeAllInColumn = (e) => {
    e.preventDefault();
    const targetEl = e.target.closest('a');
    const changeFor = targetEl.dataset.changeFor;
    const inputEls = Array.from(document.querySelectorAll(`input[id$='_${changeFor}']`));
    const amount = window.prompt('Enter input for ' + changeFor);

    if (!amount) {
        return;
    }

    inputEls.forEach((el) => {
        el.value = amount;
    });
};

const initChangeAllTrigger = (pattern) => {
    const changeAllTriggerEls = Array.from(document.querySelectorAll('.js-godmode-change-all-in-column'));

    changeAllTriggerEls.forEach((el) => {
        el.addEventListener('click', changeAllInColumn);
    });
};

const changeUser = (e) => {
    e.preventDefault();

    const select = e.target;
    const form = select.closest('form');
    const selectedUser = select.value;

    const changeUserUrlEl = document.getElementById('godmode_change_user_url');
    const baseUrl = changeUserUrlEl.dataset.baseurl;
    changeUserUrlEl.href = `${baseUrl}/${selectedUser}`;
};

const initChangeUserSelect = () => {
    const select = document.querySelector('select[name=godmode_change_user]');

    if (select) {
        select.addEventListener('change', changeUser);
    }
};

window.addEventListener('godmode-crew', initChangeAllTrigger);
window.addEventListener('godmode-ship', initChangeAllTrigger);

window.addEventListener('godmode-index', initChangeUserSelect);
window.addEventListener('godmode-user', initChangeUserSelect);
window.addEventListener('godmode-crew', initChangeUserSelect);
window.addEventListener('godmode-ship', initChangeUserSelect);
