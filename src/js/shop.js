import * as noUiSlider from 'nouislider';

const products = ['food', 'water', 'porcelain', 'spices', 'silk', 'medicine', 'tobacco', 'rum'];

$('#shop_overview a').tooltip();
$('.slider_container img').tooltip();

const onSliderChange = (inputId, sliderValue) => {
    const input = document.getElementById(inputId);
    const presenter = document.getElementById(inputId + '_presenter');

    const currentMoneyEl = document.getElementById('current_money');
    const currentMoney = parseInt(currentMoneyEl.value, 10);

    const loadMaxEl = document.getElementById('load_max');
    const loadMax = parseInt(loadMaxEl.value, 10);
    const loadTotalEl = document.querySelector('.load_total');

    const totalLoadEl = document.querySelector('.load_total');
    const totalCostEl = document.getElementById('total_cost');
    const transferTypeEl = document.getElementById('transfer_type');

    input.value = sliderValue;
    presenter.innerHTML = sliderValue;

    let totalCost = 0;
    let totalLoad = 0;

    for (let x = 0; x < products.length; x++) {
        let product = products[x];

        let newQuantityValue = $('#' + product + '_new_quantity').val();
        let newQuantity = parseInt(newQuantityValue, 10);

        let currentQuantityValue = $('#' + product + '_quantity').val();
        let currentQuantity = parseInt(currentQuantityValue, 10);

        let productPrice = 0;

        if (newQuantity > currentQuantity) {
            // User want's to buy
            const productPriceValue = $('#' + product + '_buy').val();
            productPrice = parseInt(productPriceValue, 10);

            totalCost += productPrice * (newQuantity - currentQuantity);
        } else if (currentQuantity > newQuantity) {
            // User want's to sell
            const productPriceValue = $('#' + product + '_sell').val();
            const productPrice = parseInt(productPriceValue, 10);

            totalCost -= productPrice * (currentQuantity - newQuantity);
        }

        totalLoad += newQuantity;
    }

    totalLoadEl.innerHTML = totalLoad;
    totalCostEl.innerHTML = Math.abs(totalCost);

    if (totalCost < 0) {
        transferTypeEl.innerHTML = 'Profit';
    } else {
        transferTypeEl.innerHTML = 'Cost';
    }

    if (currentMoney - totalCost < 0) {
        totalCostEl.style.color = '#d52525';
    } else {
        totalCostEl.style.color = '#000';
    }

    if (loadMax - totalLoad < 0) {
        loadTotalEl.style.color = '#d52525';
    } else {
        loadTotalEl.style.color = '#000';
    }
};

const createSlider = (sliderId, inputId, presenterId, start, minimum, maximum) => {
    const sliderEl = document.getElementById(sliderId);
    const input = document.getElementById(inputId);
    const presenter = document.getElementById(presenterId);

    if (!sliderEl) {
        return;
    }

    const slider = noUiSlider
        .create(sliderEl, {
            start: start,
            connect: 'lower',
            direction: 'rtl',
            step: 1,
            orientation: 'vertical',
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
        let amount = parseInt($('#' + product + '_quantity').val(), 10);
        let maxSlider = amount > 100 ? Math.floor(amount * 2) : Math.floor(amount + 100);

        createSlider(
            product + '-slider',
            product + '_new_quantity',
            product + '_new_quantity_presenter',
            amount,
            0,
            maxSlider
        );
    }
};

const sellBarterGoods = (e) => {
    e.preventDefault();

    for (let x = 0; x < products.length; x++) {
        let product = products[x];

        if (product != 'food' && product != 'water') {
            let currentSliderEl = document.getElementById(product + '-slider');
            currentSliderEl.noUiSlider.set(0);
        }
    }
};

const buyNecessities = (e) => {
    e.preventDefault();

    const currentFoodEl = document.getElementById('food_new_quantity');
    const currentWaterEl = document.getElementById('water_new_quantity');
    const neededFoodEl = document.getElementById('needed_food');
    const neededWaterEl = document.getElementById('needed_water');

    const currentFood = currentFoodEl.value;
    const currentWater = currentWaterEl.value;
    const neededFood = parseInt(neededFoodEl.value, 10);
    const neededWater = parseInt(neededWaterEl.value, 10);

    const foodSliderEl = document.getElementById('food-slider');
    const waterSliderEl = document.getElementById('water-slider');
    const foodSlider = foodSliderEl.noUiSlider;
    const waterSlider = waterSliderEl.noUiSlider;
    const foodMax = foodSlider.options.range.max;
    const waterMax = waterSlider.options.range.max;

    if (currentFood < neededFood) {
        if (foodMax < neededFood) {
            foodSlider.updateOptions({
                range: {
                    max: neededFood + 100
                }
            });
        }

        foodSlider.set(neededFood);
    }

    if (currentWater < neededWater) {
        if (waterMax < neededWater) {
            waterSlider.updateOptions({
                range: {
                    min: 0,
                    max: neededWater + 100
                }
            });
        }

        waterSlider.set(neededWater);
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

window.addEventListener('page_shop', (e) => {
    const buyNecessitiesTrigger = document.querySelector('.shop-buy-necessities');
    buyNecessitiesTrigger.addEventListener('click', buyNecessities);

    const sellBartGoodsTrigger = document.querySelector('.shop-sell-barter-goods');
    sellBartGoodsTrigger.addEventListener('click', sellBarterGoods);

    const resetTrigger = document.querySelector('.shop-reset');
    resetTrigger.addEventListener('click', reset);

    createSliders();
});
