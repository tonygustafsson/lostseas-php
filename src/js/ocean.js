'use strict';

const runOcean = () => {
    var appdir = $('base').attr('href');
    var sliders = ['food', 'water', 'porcelain', 'spices', 'silk', 'medicine', 'tobacco', 'rum', 'crew'];

    function tradeNecessities() {
        var currentFood = $('#food-slider').slider('option', 'value');
        var currentWater = $('#water-slider').slider('option', 'value');
        var neededFood = $('#needed_food').val();
        neededFood = parseInt(neededFood, 10);
        var neededWater = $('#needed_water').val();
        neededWater = parseInt(neededWater, 10);

        if (currentFood < neededFood) {
            if ($('#food-slider').slider('option', 'max') < neededFood) {
                $('#food-slider').slider('option', 'max', neededFood + 100);
            }
            if ($('#food-slider').slider('option', 'value', neededFood)) {
                oceanChangeSlider('#food_new_quantity', neededFood);
            }
        }

        if (currentWater < neededWater) {
            if ($('#water-slider').slider('option', 'max') < neededWater) {
                $('#water-slider').slider('option', 'max', neededWater + 100);
            }
            if ($('#water-slider').slider('option', 'value', neededWater)) {
                oceanChangeSlider('#water_new_quantity', neededWater);
            }
        }
    }

    window.tradeNecessities = tradeNecessities;

    function tradeAll() {
        var tradeWorth = parseInt($('#trade_worth').val(), 10);
        var foodCost = parseInt($('#food_price').val(), 10);
        var waterCost = parseInt($('#water_price').val(), 10);
        var foodQuantity = parseInt($('#food_quantity').val(), 10);
        var waterQuantity = parseInt($('#water_quantity').val(), 10);

        var totalFood = Math.floor(tradeWorth / 2 / foodCost);
        var totalWater = Math.floor(tradeWorth / 2 / waterCost);

        var foodNew = foodQuantity + totalFood;
        var waterNew = waterQuantity + totalWater;

        var newTradeWorth = tradeWorth - (totalFood * foodCost + totalWater * waterCost);

        if (newTradeWorth >= foodCost) {
            foodNew = foodNew + 1;
            newTradeWorth -= foodCost;
        }

        if (newTradeWorth >= waterCost) {
            waterNew = waterNew + 1;
            newTradeWorth -= waterCost;
        }

        if ($('#food-slider').slider('option', 'value', foodNew)) {
            oceanChangeSlider('#food_new_quantity', foodNew);
        }

        if ($('#water-slider').slider('option', 'value', waterNew)) {
            oceanChangeSlider('#water_new_quantity', waterNew);
        }
    }

    window.tradeAll = tradeAll;

    $(document).on('mouseover', 'area', function () {
        if ($('#town_info').length === 0) {
            var townInfo = $('<div>');
            townInfo.attr('id', 'town_info');

            var styles = {
                background: 'rgba(164,161,162,0.7)',
                border: '1px black dotted',
                padding: '4px',
                position: 'absolute',
                display: 'none'
            };
            townInfo.css(styles);

            $('body').append(townInfo);
        }

        $('#town_info').css('display', 'block');
        var content =
            '<img src="' + appdir + 'assets/images/icons/flag-' + $(this).attr('rel') + '.png"> ' + $(this).attr('alt');
        $('#town_info').html(content);
    });

    $(document).on('mouseout', 'area', function () {
        $('#town_info').css('display', 'none');
    });

    $(document).on('click', 'area', function () {
        $('#town_info').css('display', 'none');
    });

    $(document).on('mousemove', 'area', function (e) {
        var x = e.pageX + 10 + 'px';
        var y = e.pageY + 10 + 'px';

        $('#town_info').css('top', y);
        $('#town_info').css('left', x);
    });

    setTimeout(createSliders, 100);
};

window.runOcean = runOcean;
