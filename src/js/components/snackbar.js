const generateId = () => `snack-${new Date().getTime()}`;
const autoRemoveTimeMs = 4000;
const autoHideTimeMs = 3500;

const show = (msg) => {
    msg.id = generateId();

    if (!msg.level) {
        msg.level = 'info';
    }

    const snack = document.createElement('div');
    snack.id = msg.id;
    snack.classList.add('snackbar-item');
    snack.classList.add(`snackbar-item--${msg.level}`);
    snack.innerHTML = msg.text;

    document.body.prepend(snack);

    setTimeout(() => {
        snack.classList.add('snackbar-item--active');
    }, 0);

    setTimeout(() => {
        snack.classList.remove('snackbar-item--active');
    }, autoHideTimeMs);

    setTimeout(() => {
        document.body.removeChild(snack);
    }, autoRemoveTimeMs);
};

export default show;
