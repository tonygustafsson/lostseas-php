import dialog from './components/dialog.js';

window.addEventListener('inventory-ships', () => {
    const shipInfoTriggerEls = Array.from(document.querySelectorAll('.js-trigger-ship-info'));

    shipInfoTriggerEls.forEach(trigger => {
        const shipId = trigger.dataset.shipId;

        dialog({
            dialogElementId: `js-ship-info-${shipId}`,
            dialogTriggerElementId: trigger.id
        });
    });
});
