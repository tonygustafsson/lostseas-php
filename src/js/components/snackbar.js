const generateId = () => `snack-${new Date().getTime()}`;
const autoRemoveTimeMs = 4000;
const autoHideTimeMs = 3500;

let zIndex = 1000;

const show = (msg) => {
    zIndex++;

    msg.id = generateId();

    if (!msg.level) {
        msg.level = 'info';
    }

    let hover = false;

    const snack = document.createElement('div');
    snack.id = msg.id;
    snack.classList.add('snackbar-item');
    snack.classList.add(`snackbar-item--${msg.level}`);
    snack.innerHTML = msg.text;
    snack.style.zIndex = zIndex;

    snack.addEventListener('mouseover', () => {
        hover = true;
    });

    snack.addEventListener('touchstart', () => {
        hover = true;
    });

    snack.addEventListener('mouseout', () => {
        hover = false;
        snack.classList.remove('snackbar-item--active');
    });

    document.body.prepend(snack);

    setTimeout(() => {
        snack.classList.add('snackbar-item--active');
    }, 0);

    setTimeout(() => {
        if (hover) {
            return;
        }

        snack.classList.remove('snackbar-item--active');
    }, autoHideTimeMs);

    setTimeout(() => {
        if (hover) {
            return;
        }

        document.body.removeChild(snack);
    }, autoRemoveTimeMs);
};

export default show;
