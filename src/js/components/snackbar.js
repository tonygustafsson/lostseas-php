const generateId = () => `snack-${new Date().getTime()}`;

const animationSpeed = 150;
const autoRemove = true;
const autoHideTimeMs = 4000;
const autoRemoveTimeMs = animationSpeed + autoHideTimeMs;

let zIndex = 1000;

const show = (snack) => {
    const snackHeight = snack.offsetHeight;

    if (snack.animate) {
        snack.animate([{ transform: `translateY(${snackHeight}px)` }, { transform: 'translateY(0px)' }], {
            duration: animationSpeed,
            easing: 'ease-out',
            fill: 'forwards'
        });
    } else {
        // No native animations supported
        snack.style.transform = 'translateY(0px)';
    }
};

const hide = (snack) => {
    const snackHeight = snack.offsetHeight;

    if (snack.animate) {
        snack.animate([{ transform: 'translateY(0px)' }, { transform: `translateY(${snackHeight}px)` }], {
            duration: animationSpeed,
            easing: 'ease-out',
            fill: 'forwards'
        });
    } else {
        // No native animations supported
        snack.style.transform = `translateY(${snackHeight}px)`;
    }

    setTimeout(() => {
        document.body.removeChild(snack);
    }, animationSpeed);
};

const createCloseBtn = (snack) => {
    const linkEl = document.createElement('a');

    const buttonEl = document.createElement('span');
    buttonEl.classList.add('snackbar__item__close-btn');
    buttonEl.innerHTML = '&times;';

    linkEl.appendChild(buttonEl);

    linkEl.addEventListener('click', () => {
        hide(snack);
    });

    snack.appendChild(linkEl);
};

const create = (msg) => {
    zIndex++;

    msg.id = generateId();

    if (!msg.level) {
        msg.level = 'info';
    }

    let hasHovered = false;

    const snack = document.createElement('div');
    snack.id = msg.id;
    snack.classList.add('snackbar__item');
    snack.classList.add(`snackbar__item--${msg.level}`);
    snack.innerHTML = msg.text;
    snack.style.zIndex = zIndex;

    createCloseBtn(snack);

    if (autoRemove) {
        snack.addEventListener('mouseover', () => {
            hasHovered = true;
        });

        snack.addEventListener('touchstart', () => {
            hasHovered = true;
        });
    }

    document.body.prepend(snack);

    show(snack);

    if (autoRemove) {
        setTimeout(() => {
            if (hasHovered) {
                return;
            }

            hide(snack);
        }, autoHideTimeMs);
    }
};

export default create;
