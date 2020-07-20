import snackbar from './components/snackbar';

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
        'inventory_bank_stocks',
        'inventory_bank_loan'
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
                        const elementType = element.tagName.toLowerCase();
                        let newElementType = 'div';

                        if (elementType === 'table') {
                            newElementType = 'tr';
                        }

                        let appendElement = document.createElement(newElementType);
                        appendElement.innerHTML = value;
                        element.appendChild(appendElement);
                        break;
                    case 'visibility':
                        element.style.display = value;
                        break;
                    case 'remove':
                        element.remove();
                        break;
                    case 'disable':
                        element.disabled = true;
                        element.classList.add('disabled');
                        break;
                    case 'title':
                        element.title = value;
                        break;
                    case 'src':
                        element.src = value;
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

        if (sound.canPlayType('audio/aac') || sound.canPlayType('audio/x-m4a')) {
            // Get volume
            const musicControlEl = document.getElementById('music_control');
            const volume = musicControlEl.dataset.musicvolume / 100;

            sound.volume = volume;
            sound.src = `${window.appPath}assets/sounds/${data.playSound}.m4a`;
            sound.type = 'audio/aac';

            sound.load();

            sound.addEventListener('canplay', () => {
                sound.play();
                sound.remove();
            });
        }
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

    if (data.changeElements || data.loadView) {
        // View has changed, need to rerun the ajax event listneners
        window.dispatchEvent(new Event('trigger-ajax-request-listeners'));
    }
};

export default manipulateDom;
