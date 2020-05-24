import * as noUiSlider from 'nouislider';

const onSliderChange = (inputId, value) => {
    const currentMoneyEl = document.getElementById('current_money');
    const currentMoneyBankLoanEl = document.getElementById('current_money_bank_loan');
    const moneyAfterEl = document.querySelector('.money_after');
    const loanAfterEl = document.querySelector('.loan_after');
    const valueEl = document.getElementById('transfer');
    const presenterEl = document.getElementById('transfer_presenter');

    const currentMoney = parseInt(currentMoneyEl.value, 10);
    const currentMoneyBankLoan = parseInt(currentMoneyBankLoanEl.value, 10);
    const newMoney = currentMoney + value;
    const loanAfter =
        value < 0 ? Math.floor(currentMoneyBankLoan + value) : Math.floor(currentMoneyBankLoan + value * 1.15);

    valueEl.value = value;
    presenterEl.innerHTML = value;
    moneyAfterEl.innerHTML = newMoney;
    loanAfterEl.innerHTML = loanAfter;
};

const createSlider = () => {
    const inputId = 'transfer';
    const sliderEl = document.getElementById('loan-slider');

    if (!sliderEl) {
        return;
    }

    const currentMoneyEl = document.getElementById('current_money');
    const currentMoneyBankLoanEl = document.getElementById('current_money_bank_loan');
    const currentMoney = parseInt(currentMoneyEl.value, 10);
    const currentMoneyBankLoan = parseInt(currentMoneyBankLoanEl.value, 10);

    const minimum = currentMoney > currentMoneyBankLoan ? 0 - currentMoneyBankLoan : 0 - currentMoney;
    const maximum = 10000 - currentMoneyBankLoan < 0 ? 0 : 10000 - currentMoneyBankLoan;

    const slider = noUiSlider
        .create(sliderEl, {
            start: 0,
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
            onSliderChange(inputId, parseInt(value, 10));
        });
};

const bankLoanReset = () => {
    const sliderEl = document.getElementById('loan-slider');

    sliderEl.noUiSlider.set(0);
};

window.addEventListener('bank-loan', (e) => {
    const resetTrigger = document.querySelector('.js-bank-loan-reset');
    resetTrigger.addEventListener('click', bankLoanReset);

    createSlider();
});

window.addEventListener('bank-loan-post', (e) => {
    // Destroy old slider
    const sliderEl = document.getElementById('loan-slider');
    const slider = sliderEl.noUiSlider;

    slider.destroy();

    // Recreate the slider
    createSlider();
});
