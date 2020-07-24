import * as noUiSlider from 'nouislider';

const products = ['cannons', 'rafts'];

const onSliderChange = (inputId, sliderValue) => {
    const input = document.getElementById(inputId);
    const presenter = document.getElementById(inputId + '_presenter');

    const currentMoneyEl = document.getElementById('current_money');
    const currentMoney = parseInt(currentMoneyEl.value, 10);

    input.value = sliderValue;
    presenter.innerHTML = sliderValue;

    let totalCost = 0;

    for (let x = 0; x < products.length; x++) {
        let product = products[x];

        let newQuantityEl = document.getElementById(product + '_new_quantity');
        let newQuantity = parseInt(newQuantityEl.value, 10);

        let currentQuantityEl = document.getElementById(product + '_quantity');
        let currentQuantity = parseInt(currentQuantityEl.value, 10);

        let productPrice = 0;

        if (newQuantity > currentQuantity) {
            // User want's to buy
            let productPriceEl = document.getElementById(product + '_buy');
            productPrice = parseInt(productPriceEl.value, 10);

            totalCost += productPrice * (newQuantity - currentQuantity);
        } else if (currentQuantity > newQuantity) {
            // User want's to sell
            let productPriceEl = document.getElementById(product + '_sell');
            productPrice = parseInt(productPriceEl.value, 10);

            totalCost -= productPrice * (currentQuantity - newQuantity);
        }
    }

    const moneyLeftEls = document.querySelectorAll('.money_left');

    Array.from(moneyLeftEls).forEach((el) => {
        el.innerHTML = currentMoney - totalCost;

        if (currentMoney - totalCost < 0) {
            el.style.color = '#d52525';
        } else {
            el.style.color = '#000';
        }
    });
};

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
    for (let x = 0; x < products.length; x++) {
        let product = products[x];
        let amountEl = document.getElementById(product + '_quantity');
        let amount = parseInt(amountEl.value, 10);
        let maxSlider = amount + 25;

        createSlider(product + '-slider', product + '_new_quantity', amount, 0, maxSlider);
    }
};

const reset = (e) => {
    e.preventDefault();

    for (let x = 0; x < products.length; x++) {
        let product = products[x];
        let currentValueEl = document.getElementById(product + '_quantity');
        let currentValue = currentValueEl.value;

        let currentSliderEl = document.getElementById(product + '-slider');
        currentSliderEl.noUiSlider.set(currentValue);
    }
};

window.addEventListener('shipyard', (e) => {
    const resetTrigger = document.querySelector('.js-shipyard-reset');
    resetTrigger.addEventListener('click', reset);

    createSliders();
});
