import snackbar from './components/snackbar';

const base = document.getElementsByTagName('base')[0];
const appdir = base.href;

const manipulateDom = (data) => {
    if (!data) {
        return;
    }

    const invisibleElementsIfValueZero = [
        'inventory_ship_health',
        'inventory_rafts',
        'inventory_crew_mood',
        'inventory_prisoners',
        'inventory_porcelain',
        'inventory_spices',
        'inventory_silk',
        'inventory_medicine',
        'inventory_tobacco',
        'inventory_rum',
        'inventory_bank_account',
        'inventory_bank_loan',
        'inventory_new_messages'
    ];

    if (data.changeElements) {
        Object.keys(data.changeElements).forEach((elementId) => {
            Object.keys(data.changeElements[elementId]).forEach((attribute, i) => {
                let value = Object.values(data.changeElements[elementId])[i];
                let element = document.getElementById(elementId);

                if (!element) {
                    return;
                }

                switch (attribute) {
                    case 'text':
                        if (element.innerText === value.toString()) {
                            // Ignore if the same value already set
                            return;
                        }

                        element.innerText = value;

                        let container = element.parentElement.parentElement;

                        if (invisibleElementsIfValueZero.includes(elementId)) {
                            // If the text is in an element that should be invisible if 0, or not
                            let displayValue = value <= 0 ? 'none' : 'block';

                            container.style.display = displayValue;
                        }

                        // Nice effect for getting users attention
                        container.classList.add('inventory_item--updated');

                        setTimeout(() => {
                            container.classList.remove('inventory_item--updated');
                        }, 1000);

                        break;
                    case 'html':
                        element.innerHTML = value;
                        break;
                    case 'val':
                        element.value = value;
                        break;
                    case 'checked':
                        element.checked = value;
                        break;
                    case 'prepend':
                        let prependElement = document.createElement('div');
                        prependElement.innerHTML = value;
                        element.prepend(prependElement);
                        break;
                    case 'append':
                        let appendElement = document.createElement('div');
                        appendElement.innerHTML = value;
                        element.appendChild(appendElement);
                        break;
                    case 'visibility':
                        element.style.display = value;
                        break;
                    case 'remove':
                        element.remove();
                        break;
                    case 'title':
                        element.title = value;
                        break;
                    case 'default':
                        snackbar({ text: `Attribute ${attribute} is not possible to change.`, level: 'error' });
                }
            });
        });
    }

    if (data.loadView) {
        const container = document.getElementById('main');
        container.innerHTML = data.loadView;
    }

    if (data.pushState) {
        window.history.pushState({ path: data.pushState }, '', data.pushState);
    }

    if (data.playSound) {
        var sound = new Audio();
        var soundPath = appdir + 'assets/sounds/' + data.playSound;

        if (sound.canPlayType('audio/ogg')) {
            sound.src = soundPath + '.ogg';
            sound.type = 'audio/ogg';
        } else if (sound.canPlayType('audio/mp4')) {
            sound.src = soundPath + '.mp4';
            sound.type = 'audio/mp4';
        }

        sound.play();
    }

    if (data.reloadPage) {
        window.location.reload();
    }

    if (data.consoleLog) {
        data.consoleLog.forEach((log) => {
            console.log(log);
        });
    }

    if (data.success) {
        snackbar({ text: data.success, level: 'success' });
    }

    if (data.info) {
        snackbar({ text: data.info, level: 'info' });
    }

    if (data.error) {
        snackbar({ text: data.error, level: 'error' });
    }
};

export default manipulateDom;
