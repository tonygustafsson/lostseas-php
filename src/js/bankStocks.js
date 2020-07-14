import dialog from './components/dialog.js';

const createTriggers = () => {
    const stockInfoTriggerEls = Array.from(document.querySelectorAll('.js-trigger-stock-info'));

    stockInfoTriggerEls.forEach((trigger) => {
        const stockId = trigger.dataset.stockId;
        const url = `${window.appPath}bank/sell_stock/${stockId}`;

        dialog({
            dialogElementId: `js-stock-info-${stockId}`,
            dialogTriggerElementId: trigger.id,
            dialogActions: [{ title: 'Sell', url: url, primary: true }, { title: 'Cancel' }]
        });
    });

    window.dispatchEvent(new Event('updated-dom'));
};

window.addEventListener('bank-stocks', createTriggers);
