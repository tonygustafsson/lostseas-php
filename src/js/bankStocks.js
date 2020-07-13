import dialog from './components/dialog.js';

const createTriggers = () => {
    window.dispatchEvent(new Event('updated-dom'));

    const stockInfoTriggerEls = Array.from(document.querySelectorAll('.js-trigger-stock-info'));

    stockInfoTriggerEls.forEach((trigger) => {
        const stockId = trigger.dataset.stockId;

        dialog({
            dialogElementId: `js-stock-info-${stockId}`,
            dialogTriggerElementId: trigger.id
        });
    });
};

window.addEventListener('bank-stocks', createTriggers);
