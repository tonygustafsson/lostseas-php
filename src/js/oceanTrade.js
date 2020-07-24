import * as noUiSlider from 'nouislider';

const sliders = ['food', 'water', 'porcelain', 'spices', 'silk', 'medicine', 'tobacco', 'rum'];

const onSliderChange = (inputId, sliderValue) => {
    const input = document.getElementById(inputId);
    const presenter = document.getElementById(inputId + '_presenter');

    const loadCurrentEl = document.getElementById('load_current');
    const loadTotalEls = document.querySelectorAll('.load_total');
    const tradeWorthLeftEls = document.querySelectorAll('.trade_worth_left');
    const loadMaxEl = document.getElementById('load_max');
    const tradeWorthEl = document.getElementById('trade_worth');
    const tradeWorth = parseInt(tradeWorthEl.value, 10);

    input.value = sliderValue;
    presenter.innerHTML = sliderValue;

    let totalCost = 0;
    let totalLoad = parseInt(loadCurrentEl.value, 10);
    let currentMoney = tradeWorth;
    const loadMax = parseInt(loadMaxEl.value, 10);

    for (let x = 0; x < sliders.length; x++) {
        let product = sliders[x];
        let productQuantityEl = document.getElementById(product + '_new_quantity');

        if (productQuantityEl) {
            let productPriceEl = document.getElementById(product + '_price');
            let productPrice = parseInt(productPriceEl.value, 10);
            let currentQuantityEl = document.getElementById(product + '_quantity');
            let newQuantity = parseInt(productQuantityEl.value, 10);
            let currentQuantity = parseInt(currentQuantityEl.value, 10);

            totalCost += productPrice * (newQuantity - currentQuantity);
            totalLoad += newQuantity - currentQuantity;
        }
    }

    Array.from(tradeWorthLeftEls).forEach((el) => {
        el.innerHTML = currentMoney - totalCost;

        if (currentMoney - totalCost < 0) {
            el.style.color = '#d52525';
        } else {
            el.style.color = '#000';
        }
    });

    Array.from(loadTotalEls).forEach((el) => {
        el.innerHTML = totalLoad;

        if (loadMax - totalLoad < 0) {
            el.style.color = '#d52525';
        } else {
            el.style.color = '#000';
        }
    });
};

const createSlider = (sliderId, inputId, start, minimum, maximum) => {
    const sliderEl = document.getElementById(sliderId);

    if (!sliderEl) {
        return;
    }

    noUiSlider
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
    const tradeWorthEl = document.getElementById('trade_worth');
    const tradeWorth = parseInt(tradeWorthEl.value, 10);

    for (let x = 0; x < sliders.length; x++) {
        let product = sliders[x];

        let productQuantityEl = document.getElementById(product + '_quantity');

        if (!productQuantityEl) {
            continue;
        }

        let amount = parseInt(productQuantityEl.value, 10);
        let productPriceEl = document.getElementById(product + '_price');
        let productPrice = parseInt(productPriceEl.value, 10);
        let maxSlider = amount + Math.floor(tradeWorth / productPrice);

        createSlider(product + '-slider', product + '_new_quantity', amount, amount, maxSlider);
    }
};

const takeNecessities = (e) => {
    e.preventDefault();

    const neededFoodEl = document.getElementById('needed_food');
    const neededFood = parseInt(neededFoodEl.value, 10);
    const neededWaterEl = document.getElementById('needed_water');
    const neededWater = parseInt(neededWaterEl.value, 10);

    const foodSliderEl = document.getElementById('food-slider');
    const foodSlider = foodSliderEl.noUiSlider;
    const currentFood = parseInt(foodSlider.get(), 10);
    const foodSliderMax = foodSlider.options.range.max;
    const waterSliderEl = document.getElementById('water-slider');
    const waterSlider = waterSliderEl.noUiSlider;
    const currentWater = parseInt(waterSlider.get(), 10);
    const waterSliderMax = waterSlider.options.range.max;

    if (foodSliderMax < neededFood) {
        foodSlider.updateOptions({
            range: {
                min: 0,
                max: neededFood + 100
            }
        });
    }

    foodSlider.set(neededFood);

    if (waterSliderMax < neededWater) {
        waterSlider.updateOptions({
            range: {
                min: 0,
                max: neededWater + 100
            }
        });
    }

    waterSlider.set(neededWater);
};

const takeAll = (e) => {
    e.preventDefault();

    const loadCurrentEl = document.getElementById('load_current');
    const loadCurrent = parseInt(loadCurrentEl.value, 10);

    const loadMaxEl = document.getElementById('load_max');
    const loadMax = parseInt(loadMaxEl.value, 10);

    const tradeWorthEl = document.getElementById('trade_worth');
    const tradeWorth = parseInt(tradeWorthEl.value, 10);

    const foodQuantityEl = document.getElementById('food_quantity');
    const foodQuantity = parseInt(foodQuantityEl.value, 10);
    const waterQuantityEl = document.getElementById('water_quantity');
    const waterQuantity = parseInt(waterQuantityEl.value, 10);

    const foodPriceEl = document.getElementById('food_price');
    const foodPrice = parseInt(foodPriceEl.value, 10);
    const waterPriceEl = document.getElementById('water_price');
    const waterPrice = parseInt(waterPriceEl.value, 10);

    const totalFood = Math.floor(tradeWorth / 2 / foodPrice);
    const totalWater = Math.floor(tradeWorth / 2 / waterPrice);

    let foodNew = foodQuantity + totalFood;
    let waterNew = waterQuantity + totalWater;
    let newTradeWorth = tradeWorth - (totalFood * foodPrice + totalWater * waterPrice);

    if (newTradeWorth >= foodPrice) {
        foodNew = foodNew + 1;
        newTradeWorth -= foodPrice;
    }

    if (newTradeWorth >= waterPrice) {
        waterNew = waterNew + 1;
        newTradeWorth -= waterPrice;
    }

    const foodSliderEl = document.getElementById('food-slider');
    const foodSlider = foodSliderEl.noUiSlider;

    const waterSliderEl = document.getElementById('water-slider');
    const waterSlider = waterSliderEl.noUiSlider;

    foodSlider.set(foodNew);
    waterSlider.set(waterNew);
};

window.addEventListener('ocean-trade', (e) => {
    const takeNecessitiesTrigger = document.querySelector('.js-ocean-trade-take-necessities');
    if (takeNecessitiesTrigger) {
        takeNecessitiesTrigger.addEventListener('click', takeNecessities);
    }

    const takeAllTrigger = document.querySelector('.js-ocean-trade-take-all');
    if (takeAllTrigger) {
        takeAllTrigger.addEventListener('click', takeAll);
    }

    createSliders();
});
