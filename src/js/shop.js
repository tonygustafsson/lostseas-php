const runShop = () => {
    var products = ['food', 'water', 'porcelain', 'spices', 'silk', 'medicine', 'tobacco', 'rum'];

    $('#shop_overview a').tooltip();
    $('.slider_container img').tooltip();

    function shopChangeSlider(inputId, sliderValue) {
        $(inputId).val(sliderValue);
        $(inputId + '_presenter').html(sliderValue);

        var currentMoney = $('#current_money').val();
        currentMoney = parseInt(currentMoney, 10);

        var loadMax = $('#load_max').val();
        loadMax = parseInt(loadMax, 10);

        var totalCost = 0;
        var totalLoad = 0;

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

            totalLoad += newQuantity;
        }

        $('span.load_total').html(totalLoad);
        $('#total_cost').html(Math.abs(totalCost));

        if (totalCost < 0) {
            $('span#transfer_type').html('Profit');
        } else {
            $('span#transfer_type').html('Cost');
        }

        if (currentMoney - totalCost < 0) {
            $('#total_cost').css('color', '#d52525');
        } else {
            $('#total_cost').css('color', '#000');
        }

        if (loadMax - totalLoad < 0) {
            $('span.load_total').css('color', '#d52525');
        } else {
            $('span.load_total').css('color', '#000');
        }
    }

    function shopSlider(sliderId, inputId, standard, minimum, maximum) {
        $(sliderId).slider({
            orientation: 'vertical',
            range: 'min',
            animate: 'fast',
            value: standard,
            min: minimum,
            max: maximum,
            slide: function (event, ui) {
                shopChangeSlider(inputId, ui.value);
            }
        });
    }

    function createSliders() {
        if ($('#rum-slider').length) {
            var x, product, amount, maxSlider;

            for (x = 0; x < products.length; x = x + 1) {
                product = products[x];
                amount = parseInt($('#' + product + '_quantity').val(), 10);
                if (amount > 100) {
                    maxSlider = Math.floor(amount * 2);
                } else {
                    maxSlider = Math.floor(amount + 100);
                }

                shopSlider('#' + product + '-slider', '#' + product + '_new_quantity', amount, 0, maxSlider);
            }
        }
    }

    function sellBarterGoods() {
        var x, product;

        for (x = 0; x < products.length; x = x + 1) {
            product = products[x];

            if (product != 'food' && product != 'water' && $('#' + product + '-slider').slider('option', 'value', 0)) {
                shopChangeSlider('#' + product + '_new_quantity', 0);
            }
        }
    }

    function buyNecessities() {
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
                shopChangeSlider('#food_new_quantity', neededFood);
            }
        }

        if (currentWater < neededWater) {
            if ($('#water-slider').slider('option', 'max') < neededWater) {
                $('#water-slider').slider('option', 'max', neededWater + 100);
            }
            if ($('#water-slider').slider('option', 'value', neededWater)) {
                shopChangeSlider('#water_new_quantity', neededWater);
            }
        }
    }

    function resetSliders() {
        var x, product, currentValue;

        for (x = 0; x < products.length; x = x + 1) {
            product = products[x];
            currentValue = $('#' + product + '_quantity').val();

            if ($('#' + product + '-slider').slider('option', 'value', currentValue)) {
                shopChangeSlider('#' + product + '_new_quantity', currentValue);
            }
        }
    }

    setTimeout(createSliders, 100);
};

window.runShop = runShop;
