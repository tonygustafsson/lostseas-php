import * as noUiSlider from 'nouislider';

const createLoanSlider = () => {
    const currentMoneyEl = document.getElementById('current_money');
    const currentMoneyBankLoanEl = document.getElementById('current_money_bank_loan');
    const currentMoney = parseInt(currentMoneyEl.value, 10);
    const currentMoneyBankLoan = parseInt(currentMoneyBankLoanEl.value, 10);

    const min = currentMoney > currentMoneyBankLoan ? 0 - currentMoneyBankLoan : 0 - currentMoney;
    const max = 10000 - currentMoneyBankLoan < 0 ? 0 : 10000 - currentMoneyBankLoan;

    createSlider('loan-slider', 'transfer', 'transfer_presenter', 0, min, max);
};

const bankLoanReset = () => {
    if ($('#loan-slider').slider('option', 'value', 0)) {
        var currentMoney = parseInt($('#current_money').val(), 10);
        var currentMoneyBankLoan = parseInt($('#current_money_bank_loan').val(), 10);

        $('#transfer_presenter').html(0);
        $('span.money_after').html(currentMoney);
        $('span.loan_after').html(currentMoneyBankLoan);
    }

    return false;
};

window.addEventListener('bank', (e) => {
    /*
    const gambleBetSetTriggers = document.querySelectorAll('.js-tavern-bet-set');

    Array.from(gambleBetSetTriggers).forEach((setter) => {
        setter.addEventListener('click', gambleBetSet);
    });
*/
    //createAccountSlider();
});
