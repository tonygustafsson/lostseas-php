"use strict";

var appdir = $('base').attr('href');
var sliders = ['food', 'water', 'porcelain', 'spices', 'silk', 'medicine', 'tobacco', 'rum', 'crew'];

function oceanChangeSlider(inputId, sliderValue) {
	var x, product, productPrice, newQuantity, currentQuantity, newCrewQuantity, maxCrewQuantity, newCrew;
	
	$(inputId).val(sliderValue);
	$(inputId + '_presenter').html(sliderValue);

	var tradeWorth = ($('#trade_worth').length > 0) ? parseInt($('#trade_worth').val(), 10) : false;

	var totalCost = 0;
	var totalLoad = parseInt($('#load_current').val(), 10);
	var currentMoney = (tradeWorth !== false) ? tradeWorth : 0;
	var loadMax = parseInt($('#load_max').val(), 10);

	for (x = 0; x < sliders.length; x = x + 1)
	{
		product = sliders[x];

		if ($('#' + product + '-slider').length && product != "crew") {
			productPrice = (tradeWorth !== false) ? parseInt($('#' + product + '_price').val(), 10) : 0;
			newQuantity = parseInt($('#' + product + '_new_quantity').val(), 10);
			currentQuantity = parseInt($('#' + product + '_quantity').val(), 10);

			totalCost += productPrice * (newQuantity - currentQuantity);
			totalLoad += (newQuantity - currentQuantity);
		}
		
		if ($('#' + product + '-slider').length && product == "crew") {
			newCrewQuantity = parseInt($('#' + product + '_new_quantity').val(), 10);
			maxCrewQuantity = parseInt($('#crew_max').val(), 10);
			newCrew = parseInt($('#new_crew').val(), 10);
			
			if (newCrewQuantity > (maxCrewQuantity - newCrew)) {
				$('span.max_crew').css('color', '#d52525');
			}
			else
			{
				$('span.max_crew').css('color', '#000');
			}
		}
	}

	$('span.load_total').html(totalLoad);
	
	if (tradeWorth)	{
		$('span.trade_worth_left').html(currentMoney - totalCost);
	}

	if (tradeWorth && (currentMoney - totalCost) < 0) {
		$('span.trade_worth_left').css('color', '#d52525');
	}
	else {
		$('span.trade_worth_left').css('color', '#000');
	}
	
	if ((loadMax - totalLoad) < 0) {
		$('span.load_total').css('color', '#d52525');
	}
	else {
		$('span.load_total').css('color', '#000');
	}
}

function oceanSlider(sliderId, inputId, standard, minimum, maximum) {
	$(sliderId).slider({
		range: "min",
		animate: "fast",
		value: standard,
		min: minimum,
		max: maximum,
		slide: function(event, ui) {
			oceanChangeSlider(inputId, ui.value);
		}
	});
}

function createSliders() {
	var tradeWorth = ($('#trade_worth').length > 0) ? parseInt($('#trade_worth').val(), 10) : false;
	var x, product, amount, maxSlider;
	
	if ($('#crew-slider').length) {
		amount = parseInt($('#crew_quantity').val(), 10);
		maxSlider = amount + parseInt($('#new_crew').val(), 10);
		oceanSlider('#crew-slider', '#crew_new_quantity', amount, amount, maxSlider);
	}

	for (x = 0; x < sliders.length; x = x + 1) {
		product = sliders[x];

		if ($('#' + product + '-slider').length && product != "crew") {
			amount = parseInt($('#' + product + '_quantity').val(), 10);
			maxSlider = (tradeWorth !== false) ? amount + Math.floor(tradeWorth / parseInt($('#' + product + '_price').val(), 10)) : parseInt($('#' + product + '_max').val(), 10);
			oceanSlider('#' + product + '-slider', '#' + product + '_new_quantity', amount, amount, maxSlider);
		}
	}
}

function tradeNecessities() {
	var currentFood = $('#food-slider').slider('option', 'value');
	var currentWater = $('#water-slider').slider('option', 'value');
	var neededFood = $('#needed_food').val();
	neededFood = parseInt(neededFood, 10);
	var neededWater = $('#needed_water').val();
	neededWater = parseInt(neededWater, 10);

	if (currentFood < neededFood) {
		if ($('#food-slider').slider('option', 'max') < neededFood)	{
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

function tradeAll()
{
	var tradeWorth = parseInt($('#trade_worth').val(), 10);
	var foodCost = parseInt($('#food_price').val(), 10);
	var waterCost = parseInt($('#water_price').val(), 10);
	var foodQuantity = parseInt($('#food_quantity').val(), 10);
	var waterQuantity = parseInt($('#water_quantity').val(), 10);

	var totalFood = Math.floor((tradeWorth / 2) / foodCost);
	var totalWater = Math.floor((tradeWorth / 2) / waterCost);

	var foodNew = foodQuantity + totalFood;
	var waterNew = waterQuantity + totalWater;

	var newTradeWorth = tradeWorth - ((totalFood * foodCost) + (totalWater * waterCost));

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

function lootTakeAll() {
	var x, product, currentLoad, maxLoad, sliderMax, amount;

	for (x = 0; x < sliders.length; x = x + 1) {
		product = sliders[x];
		currentLoad = parseInt($('#load_current'), 10);
		maxLoad = parseInt($('#load_max'), 10);

		if ($('#' + product + '-slider').length) {
			sliderMax = parseInt($('#' + product + '-slider').slider('option', 'max'), 10);
			amount = parseInt($('#' + product + '_quantity').val(), 10);
			amount = ((amount + currentLoad) > maxLoad) ? (maxLoad - currentLoad) : sliderMax;

			if ($('#' + product + '-slider').slider('option', 'value', amount))	{
				oceanChangeSlider('#' + product + '_new_quantity', amount);
			}
		}
	}
}

$(document).on('mouseover', 'area', function() {
	if ($('#town_info').length === 0) {
		var townInfo = $('<div>');
		townInfo.attr('id', 'town_info');
		
		var styles = {background: 'rgba(164,161,162,0.7)', border: '1px black dotted', padding: '4px', position: 'absolute', display: 'none'};
		townInfo.css(styles);

		$('body').append(townInfo);
	}

	$('#town_info').css('display', 'block');
	var content = '<img src="' + appdir + 'assets/images/icons/flag-' + $(this).attr("rel") + '.png"> ' + $(this).attr("alt");
	$('#town_info').html(content);
});

$(document).on('mouseout', 'area', function() {
	$('#town_info').css('display', 'none');
});

$(document).on('click', 'area', function() {
	$('#town_info').css('display', 'none');
});

$(document).on('mousemove', 'area', function(e) {
	var x = (e.pageX + 10) + 'px';
	var y = (e.pageY + 10) + 'px';
	
	$('#town_info').css('top', y);
	$('#town_info').css('left', x);
});

setTimeout(createSliders, 100);