const runBank = () => {
    function bankLoanSlider(sliderId, inputId, standard, minimum, maximum) {
        $(sliderId).slider({
            range: 'min',
            value: standard,
            min: minimum,
            max: maximum,
            slide: function (event, ui) {
                $(inputId).val(ui.value);
                $(inputId + '_presenter').html(ui.value);

                var currentMoney = parseInt($('#current_money').val(), 10);
                var currentMoneyBankLoan = parseInt($('#current_money_bank_loan').val(), 10);

                var newMoney = currentMoney + ui.value;
                var moneyBankLoan =
                    ui.value < 0
                        ? Math.floor(currentMoneyBankLoan + ui.value)
                        : Math.floor(currentMoneyBankLoan + ui.value * 1.15);

                $('span.money_after').html(newMoney);
                $('span.loan_after').html(moneyBankLoan);
            }
        });
    }

    function bankAccountSlider(sliderId, inputId, standard, minimum, maximum) {
        $(sliderId).slider({
            range: 'min',
            value: standard,
            min: minimum,
            max: maximum,
            slide: function (event, ui) {
                $(inputId).val(ui.value);
                $(inputId + '_presenter').html(ui.value);

                var currentMoney = parseInt($('#current_money').val(), 10);
                var currentMoneyBank = parseInt($('#current_money_bank').val(), 10);

                var newMoney = currentMoney - ui.value;
                var moneyBank =
                    ui.value < 0
                        ? Math.floor(currentMoneyBank + ui.value)
                        : Math.floor(currentMoneyBank + ui.value * 0.95);

                $('span.money_after').html(newMoney);
                $('span.account_after').html(moneyBank);
            }
        });
    }

    function createSliders() {
        var currentMoney = parseInt($('#current_money').val(), 10);

        if ($('#account-slider').length) {
            var currentMoneyBank = parseInt($('#current_money_bank').val(), 10);
            bankAccountSlider('#account-slider', '#transfer', 0, 0 - currentMoneyBank, currentMoney);
        }

        if ($('#loan-slider').length) {
            var currentMoneyBankLoan = parseInt($('#current_money_bank_loan').val(), 10);

            var min = currentMoney > currentMoneyBankLoan ? 0 - currentMoneyBankLoan : 0 - currentMoney;
            var max = 10000 - currentMoneyBankLoan < 0 ? 0 : 10000 - currentMoneyBankLoan;

            bankLoanSlider('#loan-slider', '#transfer', 0, min, max);
        }
    }

    function bankAccountReset() {
        if ($('#account-slider').slider('option', 'value', 0)) {
            var currentMoney = parseInt($('#current_money').val(), 10);
            var currentMoneyBank = parseInt($('#current_money_bank').val(), 10);

            $('#transfer_presenter').html(0);
            $('span.money_after').html(currentMoney);
            $('span.account_after').html(currentMoneyBank);
        }

        return false;
    }

    function bankLoanReset() {
        if ($('#loan-slider').slider('option', 'value', 0)) {
            var currentMoney = parseInt($('#current_money').val(), 10);
            var currentMoneyBankLoan = parseInt($('#current_money_bank_loan').val(), 10);

            $('#transfer_presenter').html(0);
            $('span.money_after').html(currentMoney);
            $('span.loan_after').html(currentMoneyBankLoan);
        }

        return false;
    }

    setTimeout(createSliders, 100);
};

window.runBank = runBank;
