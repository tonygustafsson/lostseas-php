import * as noUiSlider from 'nouislider';

const createSlider = (sliderId, inputId, start, minimum, maximum) => {
    const sliderEl = document.getElementById(sliderId);
    const input = document.getElementById(inputId);

    if (!sliderEl) {
        return;
    }

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
            onSliderChange(inputId, parseInt(value, 10));
        });
};

const createSliders = () => {
    const currentMoneyEl = document.getElementById('current_money');
    const lastBetEl = document.getElementById('last_bet');

    if (!lastBetEl || !currentMoneyEl) {
        return;
    }

    const currentMoney = parseInt(currentMoneyEl.value, 10);
    const lastBet = parseInt(lastBetEl.value, 10);

    createSlider('blackjack-slider', 'bet', lastBet, 0, currentMoney);
};

const onSliderChange = (inputId, value) => {
    const inputEl = document.getElementById(inputId);
    const presenterEl = document.getElementById(inputId + '_presenter');
    const currentMoneyEl = document.getElementById('current_money');
    const moneyLeftEl = document.querySelector('.money_left');

    inputEl.value = value;
    presenterEl.innerHTML = value;

    const currentMoney = parseInt(currentMoneyEl.value, 10);
    moneyLeftEl.innerHTML = currentMoney - value;
};

const gambleBetSet = (e) => {
    const percent = parseInt(e.target.dataset.value, 10);
    const percentMoneyEl = document.getElementById('current_money');
    const currentMoney = parseInt(percentMoneyEl.value, 10);
    const gambleSliderEl = document.getElementById('blackjack-slider');
    const gambleSlider = gambleSliderEl.noUiSlider;
    const bet = Math.floor(currentMoney * (percent / 100));

    gambleSlider.updateOptions({
        range: {
            min: 0,
            max: currentMoney
        }
    });

    gambleSlider.set(bet);
};

window.addEventListener('tavern-blackjack', (e) => {
    const gambleBetSetTriggers = document.querySelectorAll('.js-tavern-bet-set');

    Array.from(gambleBetSetTriggers).forEach((setter) => {
        setter.addEventListener('click', gambleBetSet);
    });

    createSliders();
});
