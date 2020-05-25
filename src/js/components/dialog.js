const showDialog = (e, dialogEl) => {
    e.preventDefault();

    const body = document.querySelector('body');
    const backdrop = document.createElement('div');
    backdrop.classList.add('dialog-backdrop');

    backdrop.addEventListener('click', (e) => {
        closeDialog(e, dialogEl);
    });

    body.appendChild(backdrop);
    body.style.overflowY = 'hidden';

    dialogEl.classList.add('show');
};

const closeDialog = (e, dialogEl) => {
    e.preventDefault();

    const body = document.querySelector('body');
    const backdrop = document.querySelector('.dialog-backdrop');
    body.removeChild(backdrop);
    body.style.overflowY = 'scroll';

    dialogEl.classList.remove('show');
};

const dialog = (options) => {
    const { dialogElementId, dialogTriggerElementId, onLoad } = options;

    const dialogEl = document.getElementById(dialogElementId);
    const triggerEl = document.getElementById(dialogTriggerElementId);

    if (!dialogEl || !triggerEl) {
        // Dialog element did not exist
        return;
    }

    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '&times;';
    closeBtn.classList.add('dialog-close-btn');
    dialogEl.appendChild(closeBtn);

    closeBtn.addEventListener('click', (e) => {
        closeDialog(e, dialogEl);
    });

    triggerEl.addEventListener('click', (e) => {
        showDialog(e, dialogEl);

        if (onLoad) {
            onLoad();
        }
    });
};

export default dialog;
