const deviceMobileMax = 960;

const show = (elementId) => {
    const element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    element.style.display = 'block';
};

const hide = (elementId) => {
    const element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    element.style.display = 'none';
};

const toggle = (elementId) => {
    const element = document.getElementById(elementId);

    if (!element) {
        return;
    }

    if (element.style.display === 'none' || !element.style.display) {
        hide('inventory_panel');
        hide('action_panel');
        hide('nav_top');

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
    initMenu('nav_top_button', 'nav_top');
    initMenu('action_panel_button', 'action_panel');
    initMenu('inventory_panel_button', 'inventory_panel');
});

window.addEventListener('resize', (e) => {
    if (window.innerWidth >= deviceMobileMax) {
        show('inventory_panel');
        show('action_panel');
        show('nav_top');
    }
});
