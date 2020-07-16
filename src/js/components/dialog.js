const showDialog = (dialogEl) => {
    const body = document.querySelector('body');
    const backdrop = document.createElement('div');
    backdrop.classList.add('dialog-backdrop');

    backdrop.addEventListener('click', (e) => {
        closeDialog(dialogEl);
    });

    body.appendChild(backdrop);
    body.style.overflowY = 'hidden';

    dialogEl.classList.add('show');
};

const closeDialog = (dialogEl) => {
    const body = document.querySelector('body');
    const backdrop = document.querySelector('.dialog-backdrop');
    body.removeChild(backdrop);
    body.style.overflowY = 'scroll';

    dialogEl.classList.remove('show');

    if (dialogEl.dataset.domCreatedByJs) {
        body.removeChild(dialogEl);
    }
};

const createNewDialog = (dialogHeading, dialogContent) => {
    // Only used if dialogHeading and dialogContent is passed to dialog()
    const dialogEl = document.createElement('div');
    dialogEl.classList.add('dialog');
    dialogEl.tabIndex = -1;
    dialogEl.role = 'dialog';
    dialogEl.dataset.domCreatedByJs = true;

    if (dialogHeading) {
        const headingEl = document.createElement('h3');
        headingEl.classList.add('dialog-title');
        headingEl.innerText = dialogHeading;

        dialogEl.appendChild(headingEl);
    }

    const contentEl = document.createElement('div');
    contentEl.innerHTML = dialogContent;
    dialogEl.appendChild(contentEl);

    return dialogEl;
};

const createDialogActionArea = (dialogEl, dialogActions) => {
    const actionAreaEl = document.createElement('div');
    actionAreaEl.classList.add('dialog-actions');

    dialogActions.forEach((action) => {
        const linkEl = document.createElement('a');
        linkEl.classList.add('dialog-button');
        linkEl.classList.add('button');
        linkEl.classList.add('mr-1');
        linkEl.classList.add('mt-m-1');

        if (action.title) {
            linkEl.innerText = action.title;
        }

        if (action.primary) {
            linkEl.classList.add('primary');
        }

        if (action.url) {
            linkEl.classList.add('ajaxJSON');
            linkEl.href = action.url;
        }

        linkEl.addEventListener('click', (e) => {
            closeDialog(dialogEl);
        });

        actionAreaEl.appendChild(linkEl);
    });

    return actionAreaEl;
};

const createCloseButton = (dialogEl) => {
    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '&times;';
    closeBtn.classList.add('dialog-close-btn');

    closeBtn.addEventListener('click', (e) => {
        closeDialog(dialogEl);
    });

    return closeBtn;
};

const dialog = (options) => {
    const { dialogElementId, dialogTriggerElementId, dialogHeading, dialogContent, dialogActions, onLoad } = options;

    let dialogEl = document.getElementById(dialogElementId);
    const triggerEl = document.getElementById(dialogTriggerElementId);

    if (!dialogEl && !dialogContent) {
        // Dialog element did not exist and no content provided
        return;
    }

    if (!dialogEl && dialogContent) {
        // Let's create the element instead of getting it from DOM
        const body = document.querySelector('body');
        dialogEl = createNewDialog(dialogHeading, dialogContent);
        body.appendChild(dialogEl);
    }

    if (dialogActions && dialogActions.length > 0) {
        const actionAreaEl = createDialogActionArea(dialogEl, dialogActions);
        dialogEl.appendChild(actionAreaEl);
    }

    const closeBtn = createCloseButton(dialogEl);
    dialogEl.appendChild(closeBtn);

    if (triggerEl) {
        triggerEl.addEventListener('click', (e) => {
            e.preventDefault();

            showDialog(dialogEl);

            if (onLoad) {
                onLoad();
            }
        });
    } else {
        showDialog(dialogEl);
    }
};

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        // Close all dialogs if ESC is pressed.
        const dialogEls = Array.from(document.querySelectorAll('.dialog.show'));

        dialogEls.forEach((dialog) => {
            closeDialog(dialog);
        });
    }
});

export default dialog;
