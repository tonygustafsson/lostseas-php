'use strict';

var appdir = $('base').attr('href');
var products = ['cannons', 'rafts'];

$('.actions img').tooltip();

function shipyardChangeSlider(inputId, sliderValue) {
    $(inputId).val(sliderValue);
    $(inputId + '_presenter').html(sliderValue);

    var totalCost = 0;
    var currentMoney = $('#current_money').val();
    var x, product, newQuantity, currentQuantity, productPrice;

    for (x = 0; x < products.length; x = x + 1) {
        product = products[x];

        newQuantity = $('#' + product + '_new_quantity').val();
        newQuantity = parseInt(newQuantity, 10);

        currentQuantity = $('#' + product + '_quantity').val();
        currentQuantity = parseInt(currentQuantity, 10);

        if (newQuantity > currentQuantity) {
            //User want's to buy
            productPrice = $('#' + product + '_buy').val();
            productPrice = parseInt(productPrice, 10);

            totalCost += productPrice * (newQuantity - currentQuantity);
        } else {
            //User want's to sell
            productPrice = $('#' + product + '_sell').val();
            productPrice = parseInt(productPrice, 10);

            totalCost -= productPrice * (currentQuantity - newQuantity);
        }
    }

    $('span.money_left').html(currentMoney - totalCost);

    if (currentMoney - totalCost < 0) {
        $('span.money_left').css('color', '#d52525');
    } else {
        $('span.money_left').css('color', '#000');
    }
}

function shipyardCannonsSlider(sliderId, inputId, standard, minimum, maximum) {
    $(sliderId).slider({
        range: 'min',
        animate: 'fast',
        value: standard,
        min: minimum,
        max: maximum,
        slide: function (event, ui) {
            shipyardChangeSlider(inputId, ui.value);
        }
    });
}

function createSliders() {
    if ($('#rafts-slider').length) {
        var x, product, amount;

        for (x = 0; x < products.length; x = x + 1) {
            product = products[x];
            amount = parseInt($('#' + product + '_quantity').val(), 10);
            shipyardCannonsSlider('#' + product + '-slider', '#' + product + '_new_quantity', amount, 0, amount + 25);
        }
    }
}

function shipyardReset() {
    var x, product, currentValue;

    for (x = 0; x < products.length; x = x + 1) {
        product = products[x];
        currentValue = $('#' + product + '_quantity').val();

        if ($('#' + product + '-slider').slider('option', 'value', currentValue)) {
            shipyardChangeSlider('#' + product + '_new_quantity', currentValue);
        }
    }

    return false;
}

setTimeout(createSliders, 100);
