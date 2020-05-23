import * as noUiSlider from 'nouislider';

const onAccountSliderChange = (inputId, value) => {
    const inputEl = document.getElementById(inputId);
    const currentMoneyEl = document.getElementById('current_money');
    const currentMoneyBankEl = document.getElementById('current_money_bank');
    const moneyAfterEl = document.querySelector('.money_after');
    const accountAfterEl = document.querySelector('.account_after');
    const valueEl = document.getElementById('transfer');
    const presenterEl = document.getElementById('transfer_presenter');

    const currentMoney = parseInt(currentMoneyEl.value, 10);
    const currentMoneyBank = parseInt(currentMoneyBankEl.value, 10);
    const newMoney = currentMoney - value;
    const moneyBank = value < 0 ? Math.floor(currentMoneyBank + value) : Math.floor(currentMoneyBank + value * 0.95);

    valueEl.value = value;
    presenterEl.innerHTML = value;
    moneyAfterEl.innerHTML = newMoney;
    accountAfterEl.innerHTML = moneyBank;
};

const createAccountSlider = () => {
    const inputId = 'transfer';
    const sliderEl = document.getElementById('account-slider');

    if (!sliderEl) {
        return;
    }

    const currentMoneyEl = document.getElementById('current_money');
    const currentMoneyBankEl = document.getElementById('current_money_bank');
    const currentMoney = parseInt(currentMoneyEl.value, 10);
    const currentMoneyBank = parseInt(currentMoneyBankEl.value, 10);

    const start = 0;
    const minimum = 0 - currentMoneyBank;
    const maximum = currentMoney;

    const slider = noUiSlider
        .create(sliderEl, {
            start: start,
            connect: 'lower',
            direction: 'ltr',
            step: 1,
            orientation: 'horizontal',
            range: {
                min: minimum,
                max: maximum
            }
        })
        .on('update', (value) => {
            onAccountSliderChange(inputId, parseInt(value, 10));
        });
};

const bankAccountReset = () => {
    const sliderEl = document.getElementById('account-slider');

    sliderEl.noUiSlider.set(0);
};

window.addEventListener('bank', (e) => {
    const bankAccountResetTriggerEl = document.querySelector('.js-bank-account-reset');
    bankAccountResetTriggerEl.addEventListener('click', bankAccountReset);

    createAccountSlider();
});

window.addEventListener('bank-account-post', (e) => {
    // Destroy old slider
    const sliderEl = document.getElementById('account-slider');
    const slider = sliderEl.noUiSlider;
    slider.destroy();

    // Recreate the slider
    createAccountSlider();
});
