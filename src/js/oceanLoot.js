import * as noUiSlider from 'nouislider';

const sliders = ['food', 'water', 'porcelain', 'spices', 'silk', 'medicine', 'tobacco', 'rum', 'crew'];

const onSliderChange = (inputId, sliderValue) => {
    const input = document.getElementById(inputId);
    const presenter = document.getElementById(inputId + '_presenter');

    const loadCurrentEl = document.getElementById('load_current');
    const loadTotalEls = document.querySelectorAll('.load_total');
    const loadMaxEl = document.getElementById('load_max');
    const newCrewQuantityEl = document.getElementById('crew_new_quantity');
    const maxCrewQuantityEl = document.getElementById('crew_max');
    const newCrewEl = document.getElementById('new_crew');
    const maxCrewPresenterEl = document.querySelector('.max_crew');

    input.value = sliderValue;
    presenter.innerHTML = sliderValue;

    let totalLoad = parseInt(loadCurrentEl.value, 10);
    let currentMoney = 0;
    const loadMax = parseInt(loadMaxEl.value, 10);

    for (let x = 0; x < sliders.length; x++) {
        let product = sliders[x];

        if (product === 'crew' && newCrewQuantityEl) {
            let newCrewQuantity = parseInt(newCrewQuantityEl.value, 10);
            let maxCrewQuantity = parseInt(maxCrewQuantityEl.value, 10);
            let newCrew = parseInt(newCrewEl.value, 10);

            if (newCrewQuantity > maxCrewQuantity - newCrew) {
                maxCrewPresenterEl.style.color = '#d52525';
            } else {
                maxCrewPresenterEl.style.color = '#000';
            }
        } else {
            let newQuantityEl = document.getElementById(product + '_new_quantity');

            if (newQuantityEl) {
                let currentQuantityEl = document.getElementById(product + '_quantity');
                let newQuantity = parseInt(newQuantityEl.value, 10);
                let currentQuantity = parseInt(currentQuantityEl.value, 10);

                totalLoad += newQuantity - currentQuantity;
            }
        }
    }

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
    const crewQuantityEl = document.getElementById('crew_quantity');

    if (crewQuantityEl) {
        const newCrewQuantityEl = document.getElementById('new_crew');
        const crewQuantity = parseInt(crewQuantityEl.value, 10);
        const maxCrewSlider = crewQuantity + parseInt(newCrewQuantityEl.value, 10);

        createSlider('crew-slider', 'crew_new_quantity', crewQuantity, crewQuantity, maxCrewSlider);
    }

    for (let x = 0; x < sliders.length; x++) {
        let product = sliders[x];

        let productQuantityEl = document.getElementById(product + '_quantity');

        if (product === 'crew' || !productQuantityEl) {
            continue;
        }

        let productMaxEl = document.getElementById(product + '_max');
        let amount = parseInt(productQuantityEl.value, 10);
        let maxSlider = parseInt(productMaxEl.value, 10);

        createSlider(product + '-slider', product + '_new_quantity', amount, amount, maxSlider);
    }
};

const lootTakeAll = (e) => {
    e.preventDefault();

    const loadCurrentEl = document.getElementById('load_current');
    const loadCurrent = parseInt(loadCurrentEl.value, 10);

    const loadMaxEl = document.getElementById('load_max');
    const loadMax = parseInt(loadMaxEl.value, 10);

    for (let x = 0; x < sliders.length; x++) {
        let product = sliders[x];
        let sliderEl = document.getElementById(product + '-slider');

        if (sliderEl) {
            let slider = sliderEl.noUiSlider;
            let max = slider.options.range.max;

            slider.set(max);
        }
    }
};

const createEventListeners = (e) => {
    const lootTakeAllTrigger = document.querySelector('.js-ocean-loot-take-all');

    if (!lootTakeAllTrigger) {
        return;
    }

    lootTakeAllTrigger.addEventListener('click', lootTakeAll);

    createSliders();
};

window.addEventListener('ocean-ship_won', createEventListeners);
window.addEventListener('ocean-attack', createEventListeners);
window.addEventListener('ocean-flee', createEventListeners);
