const deviceMobileMax = 960;

let isMobile = window.innerWidth <= deviceMobileMax;

const show = (elementId, displayType) => {
    const element = document.getElementById(elementId);
    displayType = displayType ? displayType : 'block';

    if (!element) {
        return;
    }

    element.classList.add('show');
};

const hide = (elementId) => {
    const element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    element.classList.remove('show');
};

const toggle = (elementId) => {
    const element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    if (element.style.display === 'none' || !element.style.display) {
        hide('inventory_panel');
        hide('action_panel');
        hide('nav_top_panel');

        show(element.id);
    } else {
        hide(element.id);
    }
};

const initMenu = (triggerBtnId, panelId) => {
    const triggerBtn = document.getElementById(triggerBtnId);
    const panel = document.getElementById(panelId);

    if (!triggerBtn || !panel) {
        return;
    }

    // Avoid animation on page load
    panel.style.transition = 'transform 250ms';

    const links = Array.from(panel.getElementsByTagName('a'));

    triggerBtn.addEventListener('click', (e) => {
        e.preventDefault();
        toggle(panel.id);
    });

    links.forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= deviceMobileMax) {
                hide(panel.id);
            }
        });
    });
};

window.addEventListener('load', () => {
    initMenu('nav_top_button', 'nav_top_panel');
    initMenu('action_panel_button', 'action_panel');
    initMenu('inventory_panel_button', 'inventory_panel');

    const panelCloseTriggerEls = Array.from(document.querySelectorAll('.js-panel-close'));

    panelCloseTriggerEls.forEach((closer) => {
        closer.addEventListener('click', () => {
            hide('inventory_panel');
            hide('action_panel');
            hide('nav_top_panel');
        });
    });
});

window.addEventListener('resize', (e) => {
    const newIsMobile = window.innerWidth <= deviceMobileMax;

    if (isMobile === newIsMobile) {
        // Avoid hiding/showing on every update
        return;
    }

    if (newIsMobile) {
        hide('inventory_panel');
        hide('action_panel');
        hide('nav_top_panel');
    } else {
        show('inventory_panel');
        show('action_panel');
        show('nav_top_panel', 'flex');
    }

    console.log('Updated');

    isMobile = newIsMobile;
});
